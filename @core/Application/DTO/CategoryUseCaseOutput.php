<?php

namespace Core\Application\DTO;

use Core\Domain\Entities\Category;
use DateTime;
use DateTimeInterface;

class CategoryUseCaseOutput
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly bool $isActive,
        public readonly string|null $description,
        public readonly DateTime $createdAt,
    ) {
    }

    public static function fromEntity(Category $category): self
    {
        return new self(
            id: (string) $category->id,
            name: $category->name,
            description: $category->description,
            isActive: $category->isActive,
            createdAt: $category->createdAt
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'isActive' => $this->isActive,
            'createdAt' => $this->createdAt->format(DateTime::ATOM),
        ];
    }
}
