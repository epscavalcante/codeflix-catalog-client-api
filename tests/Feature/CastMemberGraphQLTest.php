<?php

beforeEach(fn () => $this->withoutMiddleware());

test('CastMember GraphQL: list cast members', function () {
    $response = $this->postJson('/graphql/cast-members', [
        'query' => '{
            ListCastMember {
                id,
                name,
                type,
                created_at
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
                        'type',
                        'created_at',
                    ],
                ],
            ],
        ]);
});

test('CastMember GraphQL: find castMember', function () {
    $response = $this->postJson('/graphql/cast-members', [
        'query' => '{
            FindCastMember(id: "30f23f61-0ecb-3137-98c2-a4f425757d53") {
                id,
                name,
                type,
                created_at
            }
        }',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'FindCastMember' => [
                    'id',
                    'name',
                    'type',
                    'created_at',
                ],
            ],
        ]);
});
