<?php

namespace Tests\Unit\Core\Domain\Entities;

use Core\Domain\Entities\CastMember;
use Core\Domain\Exceptions\EntityValidationException;
use Core\Domain\ValueObjects\CastMemberId;
use TypeError;

test('Deve receber exception EntityValidationException - nome longo', function () {
    new CastMember(
        name: str_repeat('Test', 256),
        type: 1
    );
})->throws(EntityValidationException::class);

test('Deve receber exception EntityValidationException - nome curto', function () {
    new CastMember(
        name: 'a',
        type: 1
    );
})->throws(EntityValidationException::class);

test('Deve receber exception EntityValidationException - type string', function () {
    new CastMember(
        name: str_repeat('Test', 256),
        type: ''
    );
})->throws(TypeError::class);

test('Deve receber exception EntityValidationException - type inexistente', function () {
    new CastMember(
        name: 'a',
        type: 999
    );
})->throws(EntityValidationException::class);

test('Deve inicializar membro do elenco do tipo DIRETOR', function () {
    $castMember = new CastMember(name: 'Test', type: 1);

    expect($castMember->type)->toBe(1);
});

test('Deve inicializar membro do elenco do tipo ATOR', function () {
    $castMember = new CastMember(name: 'Test', type: 2);

    expect($castMember->type)->toBe(2);
});

test('Deve inicializar membro do elenco com uuid automático', function () {
    $castMember = new CastMember(name: 'Test', type: 1);

    expect($castMember->id)->not->toBeString();
    expect($castMember->id)->not->toBeNull();
    expect($castMember->id)->toBeInstanceOf(CastMemberId::class);
    expect($castMember->name)->toBe('Test');
    expect($castMember->type)->toBe(1);
});

test('Deve inicializar membro do elenco com uuid via construtor', function () {
    $uuidExample = CastMemberId::generate();

    $castMember = new CastMember(
        id: $uuidExample,
        name: 'Test',
        type: 1
    );

    expect($castMember->id)->toBeInstanceOf(CastMemberId::class);
    expect($castMember->name)->toBe('Test');
    expect($castMember->type)->toBe(1);
});
