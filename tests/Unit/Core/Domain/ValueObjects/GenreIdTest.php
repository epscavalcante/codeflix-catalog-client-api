<?php

namespace Tests\Unit\Core\Domain\ValueObjects;

use Core\Domain\Exceptions\UuidValidationException;
use Core\Domain\ValueObjects\GenreId;

test('Deve receber UuidValidationException porque o valor passado não é valido', function () {
    new GenreId('fake');
})->throws(UuidValidationException::class);

test('Deve gerar um GenreId', function () {
    $genreId = GenreId::generate();

    expect($genreId)->toBeInstanceOf(GenreId::class);
});

test('Deve criar um GenreId sem um value', function () {
    $genreId = new GenreId();

    expect($genreId)->toBeInstanceOf(GenreId::class);
});

test('Deve criar um GenreId através de uma string de uuid válida', function () {
    $value = '4682d903-2bce-4269-aa89-070ed0568209';

    $genreId = new GenreId($value);

    expect($genreId)->toBeInstanceOf(GenreId::class);
});
