<?php

namespace Core\Application\DTO;

class ListCategoryUseCaseOutput
{
    /**
     * @param  array<CategoryUseCaseOut>  $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $total
    ) {
    }

    public static function toOutput(array $items, int $total): self
    {
        $categories = array_map(
            callback: fn ($category) => CategoryUseCaseOutput::fromEntity($category),
            array: $items
        );

        return new self($categories, $total);
    }
}
