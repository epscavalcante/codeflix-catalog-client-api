<?php

namespace Core\Domain\Repository;

use Core\Domain\Entities\Category;

interface CategoryRepository
{
    /**
     * @param  string  $id  ID category
     */
    public function find(string $id): Category;

    /**
     * @return array<Category>
     */
    public function search(string $query = null): array;
}
