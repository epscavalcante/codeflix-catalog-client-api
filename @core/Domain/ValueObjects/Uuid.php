<?php

namespace Core\Domain\ValueObjects;

use Core\Domain\Exceptions\UuidValidationException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        protected ?string $value = null,
    ) {
        $this->value = $value ?? (string) self::generate();

        $this->isValid($this->value);
    }

    public static function generate(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    private function isValid(string $uuid)
    {
        if (! RamseyUuid::isValid($uuid)) {
            throw new UuidValidationException($uuid);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
