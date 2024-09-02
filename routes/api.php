<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProductController;

Route::prefix('products')->group(function () {
    Route::post('/sync', [ProductController::class, 'sync']);
    Route::post('/', [ProductController::class, 'add']);
});
//Тут указать маршруты для других сущностей
//Пример:
// Route::prefix('recipes')->group(function () {
//     Route::post('/sync', [RecipeController::class, 'sync']);
//     //Route::post('/', [RecipeController::class, 'add']); В DummyJSON нельзя добавить рецепт.В любом случае есть проверка на то, можно ли добавить продукт.
// });