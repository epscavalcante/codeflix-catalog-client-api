<?php

namespace Tests\Unit\Core\Domain\Exceptions;

use Core\Domain\Exceptions\GenreNotFoundException;
use Core\Domain\ValueObjects\GenreId;

$id = GenreId::generate();
$message = 'Genre not found using ID: '.(string) $id;

test('Valida mensagem e tipo retornado', function () use ($id) {
    throw new GenreNotFoundException($id);
})->throws(GenreNotFoundException::class, $message);
