<?php

beforeEach(fn () => $this->withoutMiddleware());

test('Category GraphQL: list categories', function () {
    $response = $this->postJson('/graphql/categories', [
        'query' => '{
            ListCategory {
                id,
                name
            }
        }',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'ListCategory' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
});

test('Category GraphQL: find category', function () {
    $response = $this->postJson('/graphql/categories', [
        'query' => '{
            FindCategory(id: "30f23f61-0ecb-3137-98c2-a4f425757d53") {
                id,
                name
            }
        }',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'FindCategory' => [
                    'id',
                    'name',
                ],
            ],
        ]);

    expect($response->json())->toBe([
        'data' => [
            'FindCategory' => [
                'id' => '30f23f61-0ecb-3137-98c2-a4f425757d53',
                'name' => 'Animado',
            ],
        ],
    ]);
});
