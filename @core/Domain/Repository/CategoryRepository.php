<?php

namespace Core\Domain\Repository;

use Core\Domain\Entities\Category;
use Core\Domain\ValueObjects\CategoryId;

interface CategoryRepository
{
    /**
     * @param  CategoryId  $id  ID category
     */
    public function find(CategoryId $id): Category;

    /**
     * @return array<Category>
     */
    public function search(string $query = null): array;
}
