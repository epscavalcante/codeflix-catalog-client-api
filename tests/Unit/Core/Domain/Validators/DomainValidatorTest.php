<?php

namespace Tests\Unit\Core\Domain\Validators;

use Core\Domain\Exceptions\EntityValidationException;
use Core\Domain\Validators\DomainValidator;

test('Deve validar notNull com valor null', function () {
    DomainValidator::notNull(null);
})->throws(EntityValidationException::class);

test('Deve validar notNull com valor vazio', function () {
    DomainValidator::notNull('');
})->throws(EntityValidationException::class);

test('Deve validar notNull com valor de vários espaços', function () {
    DomainValidator::notNull('                     ');
})->throws(EntityValidationException::class);

test('Deve validar notNull com menssagem customizada', function () {
    DomainValidator::notNull('', 'Custom message');
})->throws(EntityValidationException::class, 'Custom message');

test('Deve validar maxLength com valor default', function () {
    DomainValidator::maxLength(str_repeat('a', 256));
})->throws(EntityValidationException::class);

test('Deve validar maxLength com valor máximo de 100', function () {
    DomainValidator::maxLength(str_repeat('a', 150), length: 100);
})->throws(EntityValidationException::class);

test('Deve validar maxLength com mensagem customizada', function () {
    DomainValidator::maxLength(str_repeat('a', 256), message: 'Custom message');
})->throws(EntityValidationException::class, 'Custom message');

test('Deve validar minLength com valor default', function () {
    DomainValidator::minLength(str_repeat('a', 2));
})->throws(EntityValidationException::class);

test('Deve validar minLength com valor mínimo de 5', function () {
    DomainValidator::minLength(str_repeat('a', 2), length: 5);
})->throws(EntityValidationException::class);

test('Deve validar minLength com mensagem customizada', function () {
    DomainValidator::minLength('a', message: 'Custom message');
})->throws(EntityValidationException::class, 'Custom message');
