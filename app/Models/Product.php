<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Product',
    type: 'object',
    title: 'Product',
    required: ['title', 'price', 'category', 'description'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', description: 'ID of the product', example: 1),
        new OA\Property(property: 'title', type: 'string', description: 'Title of the product', example: 'iPhone 12'),
        new OA\Property(property: 'price', type: 'number', format: 'float', description: 'Price of the product', example: 799.99),
        new OA\Property(property: 'category', type: 'string', description: 'Category of the product', example: 'smartphones'),
        new OA\Property(property: 'description', type: 'string', description: 'Description of the product', example: 'The latest iPhone with all-new features.')
    ]
)]
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'price', 'category', 'description'];

    protected $casts = [
        'title' => 'string',
        'price' => 'float',
        'category' => 'string',
        'description' => 'string',
    ];
    
}

