<?php

namespace Tests\Unit\Domain\ValueObjects;

use Core\Domain\ValueObjects\Uuid;
use InvalidArgumentException;

test('Deve invalidar a criação de uuid', function () {
    new Uuid('fake_uuid');
})->throws(InvalidArgumentException::class);

test('Deve validar o retorno de string', function () {
    $uuid = (string) Uuid::generate();

    expect($uuid)->toBeString();
});
