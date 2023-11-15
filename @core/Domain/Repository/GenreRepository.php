<?php

namespace Core\Domain\Repository;

use Core\Domain\Entities\Genre;
use Core\Domain\ValueObjects\GenreId;

interface GenreRepository
{
    public function find(GenreId $id): Genre;

    public function search(string $query = null): GenreRepositorySearchResult;
}
