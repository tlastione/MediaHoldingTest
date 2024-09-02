<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\DTO\QueryDTO;
use App\Models\Product;
use Illuminate\Http\Request;
use App\DTO\Product\ProductDTO;
use App\Services\DummyJsonClient;
use App\Http\Controllers\ApiController;
use App\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;

#[OA\Tag(name: "Продукты", description: "API Endpoints для управления продуктами")]
class ProductController extends ApiController
{
    protected const ENTITY = 'products';

    public function __construct(DummyJsonClient $client, private ProductService $productSyncService)
    {
        parent::__construct($client);
    }

    #[OA\Post(
        path: '/products/sync',
        summary: 'Синхронизировать продукты',
        description: 'Синхронизация продуктов с внешним API и сохранение их в базе данных.',
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'limit', type: 'integer', default: 30, description: 'Количество продуктов для получения'),
                    new OA\Property(property: 'skip', type: 'integer', default: 0, description: 'Количество продуктов для пропуска'),
                    new OA\Property(property: 'category', type: 'string', description: 'Категория продуктов для фильтрации'),
                    new OA\Property(property: 'search', type: 'string', description: 'Строка поиска для фильтрации продуктов'),
                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Дата и время создания'),
                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', description: 'Дата и время обновления')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Успешная синхронизация', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Product'))),
            new OA\Response(response: 400, description: 'Неверный запрос (некорректный JSON формат)'),
            new OA\Response(response: 403, description: 'Операция запрещена для данной сущности'),
            new OA\Response(response: 415, description: 'Неподдерживаемый тип данных (неверный заголовок Content-Type или Accept)'),
            new OA\Response(response: 422, description: 'Ошибка валидации входных данных'),
            new OA\Response(response: 406, description: 'Неприемлемый формат данных (неверный заголовок Accept)')
        ]
    )]
    public function sync(Request $request):JsonResponse
    {
        return parent::sync($request);
    }

    #[OA\Post(
        path: '/products',
        summary: 'Добавить новый продукт',
        description: 'Добавление нового продукта в базу данных.',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'price', 'category', 'description'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', description: 'Название продукта'),
                    new OA\Property(property: 'price', type: 'number', format: 'float', description: 'Цена продукта'),
                    new OA\Property(property: 'category', type: 'string', description: 'Категория продукта'),
                    new OA\Property(property: 'description', type: 'string', description: 'Описание продукта')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Успешное добавление', content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'id', type: 'integer', description: 'ID продукта'),
                    new OA\Property(property: 'title', type: 'string', description: 'Название продукта'),
                    new OA\Property(property: 'price', type: 'number', format: 'float', description: 'Цена продукта'),
                    new OA\Property(property: 'category', type: 'string', description: 'Категория продукта'),
                    new OA\Property(property: 'description', type: 'string', description: 'Описание продукта'),
                    new OA\Property(property: 'created_at', type: 'string', format: 'date-time', description: 'Дата и время создания'),
                    new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', description: 'Дата и время обновления')
                ]
            )),
            new OA\Response(response: 400, description: 'Неверный запрос (некорректный JSON формат)'),
            new OA\Response(response: 403, description: 'Операция запрещена для данной сущности'),
            new OA\Response(response: 415, description: 'Неподдерживаемый тип данных (неверный заголовок Content-Type или Accept)'),
            new OA\Response(response: 422, description: 'Ошибка валидации входных данных'),
            new OA\Response(response: 406, description: 'Неприемлемый формат данных (неверный заголовок Accept)'),
        ]
    )]
    public function add(Request $request): JsonResponse
    {
        return parent::add($request);
    }

    protected function saveInDatabase(array $itemData): Product
    {
        $productDTO = new ProductDTO($itemData);
        return $this->productSyncService->save($productDTO);
    }

    protected function getSyncDTO(Request $request): QueryDTO
    {
        $defaultConfig = $this->config['default_params'];
        return QueryDTO::fromRequest($request, $defaultConfig);
    }

    protected function getAddDTO(Request $request): ProductDTO
    {
        return ProductDTO::fromRequest($request);
    }
}
