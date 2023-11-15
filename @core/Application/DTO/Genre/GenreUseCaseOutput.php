<?php

namespace Core\Application\DTO\Genre;

use Core\Domain\Entities\Genre;
use DateTime;

class GenreUseCaseOutput
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly array $categoriesId,
        public readonly DateTime $createdAt,
    ) {
    }

    public static function toOutput(Genre $genre): self
    {
        return new self(
            id: (string) $genre->id,
            name: $genre->name,
            categoriesId: array_map(fn ($categoryId) => (string) $categoryId, $genre->categoriesId),
            createdAt: $genre->createdAt
        );
    }
}
