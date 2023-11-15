<?php

namespace Core\Application\DTO\Genre;

class ListGenreUseCaseInput
{
    public function __construct(
        public readonly ?string $filter = null
    ) {
    }
}
