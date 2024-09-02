<?php

namespace App\DTO\Product;

use Illuminate\Http\Request;

class ProductDTO
{
    public ?string $title;
    public ?float $price;
    public ?string $category;
    public ?string $description;

    public function __construct(array $validatedData)
    {
        $this->title = $validatedData['title'] ?? null;
        $this->price = $validatedData['price'] ?? null;
        $this->category = $validatedData['category'] ?? null;
        $this->description = $validatedData['description'] ?? null;
    }

    public static function validate(array $data): array
    {
        return validator($data, [
            'title' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'required|string',
        ])->validate();
    }

    public static function fromRequest(Request $request): self
    {
        $validatedData = self::validate($request->all());
        return new self($validatedData);
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'price' => $this->price,
            'category' => $this->category,
            'description' => $this->description,
        ];
    }
}