<?php

namespace Tests\Feature;

use Core\Domain\ValueObjects\Uuid;

test('listagem de generos api rest', function () {
    $this->getJson(route('genres.search'))
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'created_at',
                ],
            ],
        ]);
});

test('deve filtrar uma lista de generos api rest', function () {
    $this->getJson(route('genres.search', ['q' => 'Prof']))
        ->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'created_at',
                ],
            ],
        ]);
});

test('busca genero pelo id de generos api rest', function () {
    $id = '66d333ba-9bf3-3ddb-9d22-aa60b9fb0865';

    $this->getJson(route('genres.find', $id))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'created_at',
            ],
        ]);
});

test('deve receber um 400 id (uuid) inválido', function () {
    $id = 'fake';

    $this->getJson(route('genres.find', $id))
        ->assertStatus(400)
        ->assertJson([
            'status' => 400,
            'message' => "Uuid {$id} is not valid",
        ]);
});

test('deve receber um 404 genero não encontrado', function () {
    $id = (string) Uuid::generate();

    $this->getJson(route('genres.find', $id))
        ->assertStatus(404)
        ->assertJson([
            'status' => 404,
            'message' => 'Genre not found using ID: '.$id,
        ]);
});
