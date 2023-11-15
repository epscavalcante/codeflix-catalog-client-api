<?php

test('Category GraphQL: list categories', function () {
    $response = $this->postJson('/graphql', [
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
    $response = $this->postJson('/graphql', [
        'query' => '{
            FindCategory(id: "ccf66ab8-c5a1-360e-8193-7d01168f7aef") {
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
                'id' => 'ccf66ab8-c5a1-360e-8193-7d01168f7aef',
                'name' => "LightPink Witting, D'Amore and Blick",
            ],
        ],
    ]);
});
