<?php

namespace Tests\Feature;

use Core\Domain\ValueObjects\Uuid;

test('listagem de castMembers api rest', function () {
    $this->getJson(route('castMembers.search'))
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
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

test('deve filtrar uma lista de castMemers api rest', function () {
    $this->getJson(route('castMembers.search', ['q' => 'Miss Loma']))
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

test('busca categoria pelo id de categorias api rest', function () {
    $id = '1fa93532-4327-3ed4-959a-61b93c07bb6b';

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

test('deve receber um 404 categoria não encontrada', function () {
    $id = (string) Uuid::generate();

    $this->getJson(route('castMembers.find', $id))
        ->assertStatus(404)
        ->assertJson([
            'status' => 404,
            'message' => 'CastMember not found using ID: '.$id,
        ]);
});
