<?php

namespace Core\Application\DTO;

use Core\Domain\Entities\Category;

class ListCategoryUseCaseOutput
{
    /**
     * @var array<Category>
     */
    public function __construct(
        /**
         * @var array<CategoryUseCaseOutput>
         */
        public readonly array $categories,
    ) {
    }

    /**
     * @var array<Category>
     */
    public static function fromEntities(array $categories): self
    {
        $categories = array_map(
            function ($category) {
                return CategoryUseCaseOutput::fromEntity($category);
            },
            $categories
        );

        return new self($categories);
    }
}
