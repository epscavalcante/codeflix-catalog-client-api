<?php

namespace Core\Application\UseCase\Genre;

use Core\Application\DTO\Genre\ListGenreUseCaseInput;
use Core\Application\DTO\Genre\ListGenreUseCaseOutput;
use Core\Domain\Repository\GenreRepository;

class ListGenreUseCase
{
    public function __construct(
        protected GenreRepository $repository,
    ) {
    }

    public function execute(?ListGenreUseCaseInput $input = null): ListGenreUseCaseOutput
    {
        $searchResult = $this->repository->search(
            query: $input->filter ?? null
        );

        return ListGenreUseCaseOutput::toOutput(
            items: $searchResult->items,
            total: $searchResult->total
        );
    }
}
