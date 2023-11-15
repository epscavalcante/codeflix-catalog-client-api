<?php

namespace Tests\Feature;

use Core\Domain\ValueObjects\Uuid;

test('listagem de categorias api rest', function () {
    $this->getJson(route('categories.search'))
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                ],
            ],
        ]);
});

test('deve filtrar uma lista de categorias api rest', function () {
    $this->getJson(route('categories.search', ['q' => 'Darkorange']))
        ->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                ],
            ],
        ]);
});

test('busca categoria pelo id de categorias api rest', function () {
    $id = 'ccf66ab8-c5a1-360e-8193-7d01168f7aef';

    $this->getJson(route('categories.find', $id))
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
            ],
        ]);
});

test('deve receber um 400 id (uuid) inválido', function () {
    $id = 'fake';

    $this->getJson(route('categories.find', $id))
        ->assertStatus(400)
        ->assertJson([
            'status' => 400,
            'message' => "Uuid {$id} is not valid",
        ]);
});

test('deve receber um 404 categoria não encontrada', function () {
    $id = (string) Uuid::generate();

    $this->getJson(route('categories.find', $id))
        ->assertStatus(404)
        ->assertJson([
            'status' => 404,
            'message' => 'Category not found using ID: '.$id,
        ]);
});
