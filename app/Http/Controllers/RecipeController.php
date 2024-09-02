<?php

// namespace App\Http\Controllers;

// use App\DTO\QueryDTO;
// use App\DTO\Recipe\RecipeDTO;
// use App\Models\Recipe;
// use Illuminate\Http\Request;
// use App\Services\DummyJsonClient;
// use App\Http\Controllers\ApiController;
// use App\Services\Recipes\RecipeService;

// class RecipeController extends ApiController
// {
//     protected const ENTITY = 'products';
//     public function __construct(DummyJsonClient $client, private RecipeService $recipeService)
//     {
//         parent::__construct($client);
//     }

//     protected function saveInDatabase(array $itemData): Recipe
//     {
//         $recipeDTO = new RecipeDTO($itemData);
//         return $this->recipeService->save($recipeDTO);
//     }

//     protected function getSyncDTO(Request $request): QueryDTO
//     {
//         $defaultConfig = $this->config['default_params'];
//         return QueryDTO::fromRequest($request, $defaultConfig);
//     }

//     protected function getAddDTO(Request $request): RecipeDTO
//     {
//         return RecipeDTO::fromRequest($request);
//     }
// }
