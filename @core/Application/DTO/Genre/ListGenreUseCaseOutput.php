<?php

namespace Core\Application\DTO\Genre;

class ListGenreUseCaseOutput
{
    /**
     * @param  array<GenreUseCaseOutput>  $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $total,
    ) {
    }

    public static function toOutput(array $items, int $total): self
    {
        $genres = array_map(
            function ($genre) {
                return GenreUseCaseOutput::toOutput($genre);
            },
            $items
        );

        return new self($genres, $total);
    }
}
