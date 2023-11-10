<?php

namespace Core\Application\DTO;

use Core\Domain\Entities\Category;
use DateTime;

class FindCategoryUseCaseOutput
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string|null $description,
        public readonly DateTime $createdAt,
        public readonly ?bool $isActive,
    ) {
    }

    public static function fromEntity(Category $category): self
    {
        return new self(
            id: 123, //$category->id, //$category->id,
            name: 'test', //$category->name,
            description: null, //$category->description,
            isActive: true, //$category->isActive,
            createdAt: new DateTime(), //$category->createdAt
        );
    }
}
