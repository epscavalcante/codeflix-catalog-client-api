<?php

namespace Tests\Unit\Core\Domain\Exceptions;

use Core\Domain\Exceptions\CategoryNotFoundException;
use Core\Domain\ValueObjects\CategoryId;
use Core\Domain\ValueObjects\Uuid;

$id = CategoryId::generate();
$message =  "Category not found using ID: " . (string) $id;

test('Valida mensagem e tipo retornado', function () use ($id) {
    throw new CategoryNotFoundException($id);
})->throws(CategoryNotFoundException::class, $message);
