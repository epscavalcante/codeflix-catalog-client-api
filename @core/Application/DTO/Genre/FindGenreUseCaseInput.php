<?php

namespace Core\Application\DTO\Genre;

class FindGenreUseCaseInput
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
