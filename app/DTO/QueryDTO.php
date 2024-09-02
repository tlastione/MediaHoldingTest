<?php

namespace App\DTO;

use Illuminate\Http\Request;

class QueryDTO
{
    public int $limit;
    public int $skip;
    public array $select;
    public ?string $category;
    public ?string $search;

    public function __construct(array $validatedData, array $defaultConfig)
    {
        $this->limit = $validatedData['limit'] ?? $defaultConfig['limit'];
        $this->skip = $validatedData['skip'] ?? $defaultConfig['skip'];
        $this->select = $defaultConfig['select']; 
        $this->category = $validatedData['category'] ?? null;
        $this->search = $validatedData['search'] ?? null;
    }

    public static function validate(array $data): array
    {
        return validator($data, [
            'limit' => 'sometimes|integer',
            'skip' => 'sometimes|integer',
            'category' => 'sometimes|string',
            'search' => 'sometimes|string',
        ])->validate();
    }

    public static function fromRequest(Request $request, array $defaultConfig): self
    {
        $validatedData = self::validate($request->all());
        return new self($validatedData, $defaultConfig);
    }

    public function toArray(): array
    {
        return [
            'limit' => $this->limit,
            'skip' => $this->skip,
            'select' => $this->select,
            'category' => $this->category,
            'search' => $this->search,
        ];
    }
}