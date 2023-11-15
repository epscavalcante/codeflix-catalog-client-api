<?php

namespace Core\Domain\ValueObjects;

class GenreId extends Uuid
{
    public function __construct(
        protected ?string $value = null,
    ) {
        parent::__construct($value ?? self::generate());
    }

    public static function generate(): GenreId
    {
        return new self(parent::generate());
    }
}
