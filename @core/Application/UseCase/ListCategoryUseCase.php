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

    public function execute(?string $filter = null): ListCategoryUseCaseOutput
    {
        $categoriesSearched = $this->repository->search($filter);

        return ListCategoryUseCaseOutput::fromEntities($categoriesSearched);
    }
}
