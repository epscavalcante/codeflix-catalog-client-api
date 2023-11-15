<?php

namespace Tests\Unit\Core\Domain\ValueObjects;

use Core\Domain\Exceptions\UuidValidationException;
use Core\Domain\ValueObjects\CastMemberId;

test('Deve receber UuidValidationException porque o valor passado não é valido', function () {
    new CastMemberId('fake');
})->throws(UuidValidationException::class);

test('Deve gerar um CastMemberId', function () {
    $castMemberId = CastMemberId::generate();

    expect($castMemberId)->toBeInstanceOf(CastMemberId::class);
});

test('Deve criar um CastMemberId sem um value', function () {
    $castMemberId = new CastMemberId();

    expect($castMemberId)->toBeInstanceOf(CastMemberId::class);
});

test('Deve criar um CastMemberId através de uma string de uuid válida', function () {
    $value = '4682d903-2bce-4269-aa89-070ed0568209';

    $castMemberId = new CastMemberId($value);

    expect($castMemberId)->toBeInstanceOf(CastMemberId::class);
});
