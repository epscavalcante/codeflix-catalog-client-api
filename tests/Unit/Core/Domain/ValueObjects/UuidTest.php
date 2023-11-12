<?php

namespace Tests\Unit\Core\Domain\ValueObjects;

use Core\Domain\Exceptions\UuidValidationException;
use Core\Domain\ValueObjects\Uuid;

test('Deve receber UuidValidationException porque o valor passado não é valdo', function () {
    new Uuid('fake');
})->throws(UuidValidationException::class);

test('Deve gerar um Uuid', function () {
    $uuid = Uuid::generate();

    expect($uuid)->toBeInstanceOf(Uuid::class);
});

test('Deve criar um Uuid sem um value', function () {
    $uuid = new Uuid();

    expect($uuid)->toBeInstanceOf(Uuid::class);
});

test('Deve criar um Uuid através de uma string de uuid válida', function () {
    $value = '4682d903-2bce-4269-aa89-070ed0568209';

    $uuid = new Uuid($value);

    expect($uuid)->toBeInstanceOf(Uuid::class);
});
