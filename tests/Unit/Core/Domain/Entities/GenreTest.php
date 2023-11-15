<?php

namespace Tests\Unit\Core\Domain\Entities;

use Core\Domain\Entities\Genre;
use Core\Domain\Exceptions\EntityValidationException;
use Core\Domain\ValueObjects\CategoryId;
use Core\Domain\ValueObjects\GenreId;
use DateTime;

test('Deve receber exception EntityValidationException - nome longo', function () {
    new Genre(
        name: str_repeat('Test', 256),
    );
})->throws(EntityValidationException::class);

test('Deve receber exception EntityValidationException - nome curto', function () {
    new Genre(
        name: 'a',
    );
})->throws(EntityValidationException::class);

// test('Deve receber exception EntityValidationException - type string', function () {
//     new Genre(
//         name: str_repeat('Test', 256),
//     );
// })->throws(TypeError::class);

// test('Deve receber exception EntityValidationException - type inexistente', function () {
//     new Genre(
//         name: 'a',
//     );
// })->throws(EntityValidationException::class);

test('Deve inicializar gênero sem categorias', function () {
    $genre = new Genre(name: 'Test');

    expect($genre->id)->toBeInstanceOf(GenreId::class);
    expect($genre->createdAt)->toBeInstanceOf(DateTime::class);
    expect($genre->categoriesId)->toBeArray();
    expect($genre->categoriesId)->toHaveCount(0);
    expect($genre->name)->toBe('Test');
});

test('Deve inicializar gênero com N categorias', function () {
    $categoriesId = [
        CategoryId::generate(),
        CategoryId::generate(),
    ];
    $genre = new Genre(name: 'Test', categoriesId: $categoriesId);

    expect($genre->id)->toBeInstanceOf(GenreId::class);
    expect($genre->createdAt)->toBeInstanceOf(DateTime::class);
    expect($genre->categoriesId)->toBeArray();
    expect($genre->categoriesId)->toHaveCount(2);
    expect($genre->categoriesId[0])->toBeInstanceOf(CategoryId::class);
    expect((string) $genre->categoriesId[0])->toBe((string) $categoriesId[0]);
    expect((string) $genre->categoriesId[1])->toBe((string) $categoriesId[1]);
    expect($genre->name)->toBe('Test');
});

test('Deve adicionar ID de categorias', function () {
    $categoriesId = [
        CategoryId::generate(),
        CategoryId::generate(),
    ];
    $genre = new Genre(name: 'Test');

    expect($genre->categoriesId)->toHaveCount(0);

    $genre->addCategory($categoriesId[0]);

    expect($genre->categoriesId)->toHaveCount(1);
    expect($genre->categoriesId[0])->toBeInstanceOf(CategoryId::class);
    expect((string) $genre->categoriesId[0])->toBe((string) $categoriesId[0]);
});

test('Deve remove ID de categorias', function () {
    $categoriesId = [
        CategoryId::generate(),
    ];
    $genre = new Genre(name: 'Test', categoriesId: $categoriesId);

    expect($genre->categoriesId)->toHaveCount(1);

    $genre->removeCategory($categoriesId[0]);

    expect($genre->categoriesId)->toHaveCount(0);
});
