<?php

namespace Core\Application\UseCase;

use Core\Application\DTO\ListCategoryUseCaseOutput;
use Core\Domain\Repository\CategoryRepository;

class ListCategoryUseCase
{
    public function __construct(
        protected CategoryRepository $repository,
    ) {
    }

    public function execute(): ListCategoryUseCaseOutput
    {
        $categoriesSearched = $this->repository->search();

        return ListCategoryUseCaseOutput::fromEntities($categoriesSearched);
    }
}
