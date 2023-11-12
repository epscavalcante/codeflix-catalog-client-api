<?php

namespace Tests\Unit\Core\Domain\ValueObjects;

use Core\Domain\Exceptions\UuidValidationException;
use Core\Domain\ValueObjects\CategoryId;

test('Deve receber UuidValidationException porque o valor passado não é valdo', function () {
    new CategoryId('fake');
})->throws(UuidValidationException::class);

test('Deve gerar um CategoryId', function () {
    $categoryId = CategoryId::generate();

    expect($categoryId)->toBeInstanceOf(CategoryId::class);
});

test('Deve criar um CategoryId sem um value', function () {
    $categoryId = new CategoryId();

    expect($categoryId)->toBeInstanceOf(CategoryId::class);
});

test('Deve criar um CategoryId através de uma string de uuid válida', function () {
    $value = '4682d903-2bce-4269-aa89-070ed0568209';

    $categoryId = new CategoryId($value);

    expect($categoryId)->toBeInstanceOf(CategoryId::class);
});
