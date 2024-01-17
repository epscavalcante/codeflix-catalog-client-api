<?php

use Core\Domain\ValueObjects\Uuid;

beforeEach(fn () => $this->withoutMiddleware());

test('listagem de castMembers api rest', function () {
    $this->getJson(route('castMembers.search'))
        ->assertStatus(200)
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'type',
                    'created_at',
                ],
            ],
        ]);
});

test('deve filtrar uma lista de castMembers api rest', function () {
    $this->getJson(route('castMembers.search', ['q' => 'Diretor']))
        ->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'type',
                    'created_at',
                ],
            ],
        ]);
});

test('busca castMember pelo id', function () {
    $id = '30f23f61-0ecb-3137-98c2-a4f425757d53';

    $this->getJson(route('castMembers.find', $id))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'type',
                'created_at',
            ],
        ]);
});

test('deve receber um 400 id (uuid) inválido', function () {
    $id = 'fake';

    $this->getJson(route('castMembers.find', $id))
        ->assertStatus(400)
        ->assertJson([
            'status' => 400,
            'message' => "Uuid {$id} is not valid",
        ]);
});

test('deve receber um 404 castMember não encontrado', function () {
    $id = (string) Uuid::generate();

    $this->getJson(route('castMembers.find', $id))
        ->assertStatus(404)
        ->assertJson([
            'status' => 404,
            'message' => 'CastMember not found using ID: '.$id,
        ]);
});
