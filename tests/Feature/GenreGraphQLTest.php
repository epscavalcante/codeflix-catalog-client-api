<?php

beforeEach(fn () => $this->withoutMiddleware());

test('Genre GraphQL: list categories', function () {
    $response = $this->postJson('/graphql/genres', [
        'query' => '{
            ListGenre {
                id,
                name,
                created_at
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
                        'created_at',
                    ],
                ],
            ],
        ]);
});

test('Genre GraphQL: find genre', function () {
    $response = $this->postJson('/graphql/genres', [
        'query' => '{
            FindGenre(id: "30f23f61-0ecb-3137-98c2-a4f425757d53") {
                id,
                name,
                created_at
            }
        }',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'FindGenre' => [
                    'id',
                    'name',
                    'created_at',
                ],
            ],
        ]);

    expect($response->json())->toBe([
        'data' => [
            'FindGenre' => [
                'id' => '30f23f61-0ecb-3137-98c2-a4f425757d53',
                'name' => 'Filme',
                'created_at' => '2017-04-07T07:06:33+00:00',
            ],
        ],
    ]);
});
