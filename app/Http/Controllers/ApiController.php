<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Services\DummyJsonClient;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

#[OA\Info(
    title: 'API Documentation',
    version: '1.0.0',
    description: 'API'
)]
abstract class ApiController extends Controller
{
    protected const ENTITY = self::ENTITY;

    public function __construct(protected DummyJsonClient $client, protected array $config = [])
    {
        $this->client = $client;
        $this->config = config('api.' . static::ENTITY);
    }

    public function sync(Request $request):JsonResponse
    {
        $this->ensureOperationAllowed('sync');

        if (!$this->isValidJson($request->getContent())) {
            return response()->json(['status' => 'error', 'message' => 'Invalid JSON format'], 400);
        }

        $queryDTO = $this->getSyncDTO($request);

        [$endpoint, $params] = $this->buildEndpointAndParams($queryDTO);
        $response = $this->client->fetchItems($endpoint, $params);
        $items = $response[static::ENTITY] ?? [];

        if ($queryDTO->category && $queryDTO->search) {
            $titleKey = $this->config['title_key'];
            $items = array_filter($items, function ($item) use ($queryDTO, $titleKey) {
                return strpos(strtolower($item[$titleKey]), strtolower($queryDTO->search)) !== false;
            });
        }
        
        $savedItems = [];
        foreach ($items as $item) {
            $savedItems[] = $this->saveInDatabase($item);
        }

        return response()->json(['status' => 'success', 'data' => $savedItems]);
    }

    public function add(Request $request): JsonResponse
    {
        $this->ensureOperationAllowed('add');

        if (!$this->isValidJson($request->getContent())) {
            return response()->json(['status' => 'error', 'message' => 'Invalid JSON format'], 400);
        }
        
        $addDTO = $this->getAddDTO($request);

        $response = $this->client->addItem($this->config['add_endpoint'], $addDTO->toArray());
        $savedItem = $this->storeInDatabase($response);

        return response()->json(['status' => 'success', 'data' => $savedItem], 201);
    }

    protected function ensureOperationAllowed(string $operation)
    {
        if (!in_array($operation, $this->config['operations'])) {
            abort(403, "Operation '{$operation}' is not allowed for this entity.");
        }
    }

    protected function buildEndpointAndParams($queryDTO): array
    {
        $endpoint = $this->config['endpoint'];
        $params = array_merge($this->config['default_params'], [
            'limit' => $queryDTO->limit,
            'skip' => $queryDTO->skip,
            'select' => implode(',', $queryDTO->select),
        ]);

        if ($queryDTO->category && !$queryDTO->search) {
            $endpoint = str_replace('{category}', $queryDTO->category, $this->config['category_endpoint']);
        } elseif (!$queryDTO->category && $queryDTO->search) {
            $endpoint = $this->config['search_endpoint'];
            $params['q'] = $queryDTO->search;
        } elseif ($queryDTO->category && $queryDTO->search) {
            $endpoint = str_replace('{category}', $queryDTO->category, $this->config['category_endpoint']);
        }

        return [$endpoint, $params];
    }
    
    protected function isValidJson($jsonString): bool
    {
        $decoded = json_decode($jsonString, true);
        return $decoded !== null;
    }

    abstract protected function getSyncDTO(Request $request);
    abstract protected function getAddDTO(Request $request);

    abstract protected function saveInDatabase(array $item): Model;
}
