<?php

namespace Tests;

use Illuminate\Support\Arr;

$castMembers = json_decode(file_get_contents('/var/www/storage/app/mocks/cast-members.json'), true);
$categories = json_decode(file_get_contents('/var/www/storage/app/mocks/categories.json'),  true);
$genres = json_decode(file_get_contents('/var/www/storage/app/mocks/genres.json'), true);

dataset('elasticdata.categories', [
    'empty' => [[]],
    'withItems' => [
        Arr::map($categories, function ($item) {
            return [
                '_source' => [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'is_active' => $item['is_active'],
                    'created_at' => $item['created_at'],
                ]
            ];
        })
    ],
]);

dataset('elasticdata.cast_members', [
    'empty' => [[]],
    'withItems' => [
        Arr::map($castMembers, function ($item) {
            return [
                '_source' => [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'created_at' => $item['created_at'],
                ]
            ];
        })
    ]
]);

dataset('elasticdata.genres', [
    // 'empty' => [[]],
    'withItems' => [
        Arr::map($genres, function ($item) {
            return [
                '_source' => [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'categories_id' => $item['categories_id'],
                    'created_at' => $item['created_at'],
                ]
            ];
        })
    ],
]);
