<?php

namespace Core\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        protected string $value,
    ) {
        $this->isValid($value);
    }

    public static function generate(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    private function isValid(string $uuid)
    {
        if (! RamseyUuid::isValid($uuid)) {
            throw new InvalidArgumentException('Invalid uuid');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
