<?php

namespace Tests\Unit\Core\Domain\Entities;

use Core\Domain\Entities\Category;
use Core\Domain\Exceptions\EntityValidationException;
use Core\Domain\ValueObjects\CategoryId;
use DateTime;

test('Deve receber exception EntityValidationException - nome longo', function () {
    new Category(
        name: str_repeat('Test', 256)
    );
})->throws(EntityValidationException::class);

test('Deve receber exception EntityValidationException - nome curto', function () {
    new Category(
        name: 'a'
    );
})->throws(EntityValidationException::class);

test('Deve receber exception EntityValidationException - description longa', function () {
    new Category(
        name: 'abc',
        description: str_repeat('a', 2000)
    );
})->throws(EntityValidationException::class);

test('Deve inicializar categoria com nome e propriedades padrão', function () {
    $category = new Category(name: 'Test');

    expect($category->name)->toBe('Test');
    expect($category->description)->toBeNull();
    expect($category->isActive)->toBeTrue();
    expect($category->createdAt)->toBeInstanceOf(DateTime::class);
});

test('Deve inicializar categoria com nome e descrição', function () {
    $category = new Category(name: 'Test', description: 'Test');

    expect($category->name)->toBe('Test');
    expect($category->description)->toBe('Test');
    expect($category->isActive)->toBeTrue();
    expect($category->createdAt)->toBeInstanceOf(DateTime::class);
});

test('Deve inicializar categoria inativa', function () {
    $category = new Category(name: 'Test', isActive: false);

    expect($category->isActive)->toBe(false);
});

test('Deve inicializar categoria ativa', function () {
    $category = new Category(name: 'Test', isActive: true);

    expect($category->isActive)->toBe(true);
});

test('Deve inicializar categoria com uuid automático', function () {
    $category = new Category(name: 'Test');

    expect($category->id)->not->toBeString();
    expect($category->id)->not->toBeNull();
    expect($category->id)->toBeInstanceOf(CategoryId::class);
});

test('Deve inicializar categoria com uuid via construtor', function () {
    $uuidExample = CategoryId::generate();

    $category = new Category(
        id: $uuidExample,
        name: 'Test'
    );

    expect($category->id)->not->toBeString();
    expect($category->id)->not->toBeNull();
    expect($category->id)->toBeInstanceOf(CategoryId::class);
});

test('Deve inativar uma categoria', function () {
    $category = new Category(
        id: CategoryId::generate(),
        name: 'Test'
    );

    $category->deactivate();

    expect($category->isActive)->toBe(false);
});

test('Deve ativar uma categoria', function () {
    $category = new Category(
        id: CategoryId::generate(),
        name: 'Test',
        isActive: false
    );

    $category->activate();

    expect($category->isActive)->toBe(true);
});
