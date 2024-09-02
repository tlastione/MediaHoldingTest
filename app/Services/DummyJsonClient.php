<?php
 
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;

class DummyJsonClient
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.dummyjson.base_url', 'https://dummyjson.com');
    }

    public function fetchItems(string $endpoint, array $params = []): array
    {
        $response = Http::get("{$this->baseUrl}{$endpoint}", $params);
        
        if ($response->successful()) {
            return $response->json();
        }

        $this->handleErrorResponse($response);
    }

    public function addItem(string $endpoint, array $data): array
    {
        $addEndpoint = $this->config['add_endpoint'] ?? $endpoint;
        $response = Http::post("{$this->baseUrl}{$addEndpoint}", $data);
        if ($response->successful()) {
            return $response->json();
        }

        $this->handleErrorResponse($response);
    }

    private function handleErrorResponse($response)
    {
        $status = $response->status();
        $message = $response->json('message') ?? 'Failed to communicate with the API';

        throw new HttpResponseException(response()->json([
            'error' => $message,
        ], $status));
    }
}
