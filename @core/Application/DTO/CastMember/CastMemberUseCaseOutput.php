<?php

namespace Core\Application\DTO\CastMember;

use Core\Domain\Entities\CastMember;
use DateTime;

class CastMemberUseCaseOutput
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $type,
        public readonly DateTime $createdAt,
    ) {
    }

    public static function fromEntity(CastMember $castMember): self
    {
        return new self(
            id: (string) $castMember->id,
            name: $castMember->name,
            type: $castMember->type,
            createdAt: $castMember->createdAt
        );
    }
}
