<?php

namespace Core\Domain\ValueObjects;

class CategoryId extends Uuid
{
    public function __construct(
        protected ?string $value = null,
    ) {
        parent::__construct($value ?? self::generate());
    }

    public static function generate(): CategoryId
    {
        return new self(parent::generate());
    }
}
