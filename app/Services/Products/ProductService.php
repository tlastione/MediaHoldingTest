<?php

namespace App\Services\Products;

use App\Models\Product;
use App\DTO\Product\ProductDTO;

class ProductService
{
    public function save(ProductDTO $productDTO): Product
    {
        return Product::updateOrCreate(
            ['title' => $productDTO->title],
            $productDTO->toArray()
        );
    }
}

