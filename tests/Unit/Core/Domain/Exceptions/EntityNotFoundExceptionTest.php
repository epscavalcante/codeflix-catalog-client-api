<?php

namespace Tests\Unit\Core\Domain\Exceptions;

use Core\Domain\Exceptions\EntityNotFoundException;


test('Valida mensagem padrão retornada', function () {
    throw new EntityNotFoundException();
})->throws(EntityNotFoundException::class, 'Entity not found');

test('Valida mensagem customizada retornada', function () {
    throw new EntityNotFoundException('Fake message');
})->throws(EntityNotFoundException::class, 'Fake message');
