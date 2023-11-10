<?php

namespace Core\Application\DTO;

use Core\Domain\Entities\Category;

class ListCategoryUseCaseOutput
{
    /**
     * @var array<Category>
     */
    public function __construct(
        public readonly array $categories,
    ) {
    }

    /**
     * @var array<Category>
     */
    public static function fromEntities(array $categories): self
    {
        return new self($categories);
    }
}
