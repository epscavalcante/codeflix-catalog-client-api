<?php

test('Genre GraphQL: list categories', function () {
    $response = $this->postJson('/graphql', [
        'query' => '{
            ListGenre {
                id,
                name
            }
        }',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'ListGenre' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
});

test('Genre GraphQL: find genre', function () {
    $response = $this->postJson('/graphql', [
        'query' => '{
            FindGenre(id: "66d333ba-9bf3-3ddb-9d22-aa60b9fb0865") {
                id,
                name
            }
        }',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'FindGenre' => [
                    'id',
                    'name',
                ],
            ],
        ]);

    expect($response->json())->toBe([
        'data' => [
            'FindGenre' => [
                'id' => '66d333ba-9bf3-3ddb-9d22-aa60b9fb0865',
                'name' => 'Prof. Emerald McKenzie',
            ],
        ],
    ]);
});
