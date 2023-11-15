<?php

namespace Core\Domain\Repository;

use Core\Domain\Entities\Genre;

class GenreRepositorySearchResult
{
    /**
     * @param  array<Genre>  $items
     */
    public function __construct(
        public int $total,
        public array $items,
    ) {
    }
}
