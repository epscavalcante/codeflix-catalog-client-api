<?php

namespace Core\Domain\Validators;

use Core\Domain\Exceptions\EntityValidationException;

class DomainValidator
{
    public static function notNull(
        string $value = null,
        string $message = 'value must not be empty'
    ) {
        if (is_null($value) || empty(trim($value))) {
            throw new EntityValidationException($message);
        }
    }

    public static function maxLength(
        string $value,
        int $length = 255,
        string $message = 'value must be less than %s characters'
    ) {
        if (strlen($value) > $length) {
            throw new EntityValidationException(sprintf($message, $length));
        }
    }

    public static function minLength(
        string $value,
        int $length = 3,
        string $message = 'value must be greater than %s characters'
    ) {
        if (strlen($value) < $length) {
            throw new EntityValidationException(sprintf($message, $length));
        }
    }

    public static function isANumber(
        mixed $value,
        string $message = 'value must be a number'
    ) {
        if (! is_numeric($value)) {
            throw new EntityValidationException($message);
        }
    }

    public static function isA(
        mixed $value,
        string $class,
        string $message = 'value must be an instance of %s'
    ) {
        if (! is_a($value, $class)) {
            throw new EntityValidationException(sprintf($message, $class));
        }
    }
}
