<?php

return [
    'products' => [
        'endpoint' => '/products',
        'add_endpoint' => '/products/add',
        'category_endpoint' => '/products/category/{category}',
        'search_endpoint' => '/products/search',
        'default_params' => [
            'limit' => 30,
            'skip' => 0,
            'select' => [
                'id', 
                'title', 
                'price', 
                'category',
                'description',
            ],
        ],
        'custom_params' => [
            'category',
            'search',
        ],
        'operations' => ['sync', 'add'], // Не все сущности поддерживают добавление.
        'title_key' => 'title',  //Для поиска в случае если есть и category и search. В recipes поле называется name
    ],
    //Так бы мог выглядеть конфиг для рецептов.
    // 'recipes' => [
    //     'endpoint' => '/recipes',
    //     'category_endpoint' => '/recipes/category/{category}',
    //     'search_endpoint' => '/recipes/search',
    //     'default_params' => [
    //         'limit' => 30,
    //         'skip' => 0,
    //         'select' => [            
    //             'id', 
    //             'name', 
    //             'ingredients', 
    //             'instructions', 
    //             'prepTimeMinutes', 
    //             'cookTimeMinutes', 
    //             'servings', 
    //         ],
    //     ],
    //     'custom_params' => [
    //         'category',
    //         'search',
    //     ],
    //     'operations' => ['sync'], 
    //     'title_key' => 'name', 
    // ],
    // другие сущности
];