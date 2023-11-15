<?php

namespace Core\Application\UseCase\Genre;

use Core\Application\DTO\Genre\FindGenreUseCaseInput;
use Core\Application\DTO\Genre\GenreUseCaseOutput;
use Core\Domain\Repository\GenreRepository;
use Core\Domain\ValueObjects\GenreId;

class FindGenreUseCase
{
    public function __construct(
        protected GenreRepository $repository,
    ) {
    }

    public function execute(FindGenreUseCaseInput $input): GenreUseCaseOutput
    {
        $genreId = new GenreId($input->id);
        $genreFound = $this->repository->find($genreId);

        return GenreUseCaseOutput::toOutput($genreFound);
    }
}
