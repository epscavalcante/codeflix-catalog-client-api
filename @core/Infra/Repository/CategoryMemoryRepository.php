<?php

namespace Core\Infra\Repository;

use Core\Domain\Entities\Category;
use Core\Domain\Repository\CategoryRepository;

class CategoryMemoryRepository implements CategoryRepository
{
    public function __construct(
        public array $items = [
            new Category('Teste'),
        ]
    ) {
    }

    public function find(string $id): Category
    {
        return $this->items[0];
    }

    public function search(): array
    {
        return $this->items;
    }
}
