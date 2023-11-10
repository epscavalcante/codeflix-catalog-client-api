<?php

namespace Core\Application\DTO;

use Core\Domain\Entities\Category;

class ListCategoryUseCaseOutput
{   
    /**
     * @var array<Category> $categories
     */
    public function __construct(
        public readonly array $categories,
    ) {
    }

    /**
     * @var array<Category> $categories
     * @return self
     */
    public static function fromEntities(array $categories): self
    {
        return new self($categories);
    }
}
