<?php

// namespace App\DTO\Recipe;

// use Illuminate\Http\Request;

// class RecipeDTO
// {
//     public $id;
//     public $name;
//     public $ingredients;
//     public $instructions;
//     public $category;
//     public $servings;
//     public $prepTimeMinutes;
//     public $cookTimeMinutes;

//     public function __construct(array $data)
//     {
//         $this->id = $data['id'] ?? null;
//         $this->name = $data['name'] ?? '';
//         $this->ingredients = $data['ingredients'] ?? [];
//         $this->instructions = $data['instructions'] ?? [];
//         $this->category = $data['category'] ?? '';
//         $this->servings = $data['servings'] ?? null;
//         $this->prepTimeMinutes = $data['prepTimeMinutes'] ?? null;
//         $this->cookTimeMinutes = $data['cookTimeMinutes'] ?? null;
//     }

//     public static function validate(array $data): array
//     {
//         return validator($data, [
//             'id' => 'sometimes|integer',
//             'name' => 'required|string',
//             'ingredients' => 'required|array',
//             'instructions' => 'required|array',
//             'category' => 'required|string',
//             'servings' => 'required|integer',
//             'prepTimeMinutes' => 'required|integer',
//             'cookTimeMinutes' => 'required|integer',
//         ])->validate();
//     }

//     public static function fromRequest(Request $request): self
//     {
//         $validatedData = self::validate($request->all());
//         return new self($validatedData);
//     }

//     public function toArray(): array
//     {
//         return [
//             'id' => $this->id,
//             'name' => $this->name,
//             'ingredients' => $this->ingredients,
//             'instructions' => $this->instructions,
//             'category' => $this->category,
//             'servings' => $this->servings,
//             'prepTimeMinutes' => $this->prepTimeMinutes,
//             'cookTimeMinutes' => $this->cookTimeMinutes,
//         ];
//     }
// }