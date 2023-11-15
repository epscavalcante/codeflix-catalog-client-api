<?php

test('CastMember GraphQL: list cast members', function () {
    $response = $this->postJson('/graphql', [
        'query' => '{
            ListCastMember {
                id,
                name
            }
        }',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'ListCastMember' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ],
        ]);
});

test('CastMember GraphQL: find castMember', function () {
    $response = $this->postJson('/graphql', [
        'query' => '{
            FindCastMember(id: "279d845e-4f33-3251-b1cb-5d48bb19c9dc") {
                id,
                name
            }
        }',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'FindCastMember' => [
                    'id',
                    'name',
                ],
            ],
        ]);
});
