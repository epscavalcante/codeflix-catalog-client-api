<?php

namespace Core\Domain\ValueObjects;

class CastMemberId extends Uuid
{
    public function __construct(
        protected ?string $value = null,
    ) {
        parent::__construct($value ?? self::generate());
    }

    public static function generate(): CastMemberId
    {
        return new self(parent::generate());
    }
}
