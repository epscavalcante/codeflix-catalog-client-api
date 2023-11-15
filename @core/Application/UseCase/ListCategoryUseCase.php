<?php

namespace Core\Application\UseCase;

use Core\Application\DTO\ListCategoryUseCaseInput;
use Core\Application\DTO\ListCategoryUseCaseOutput;
use Core\Domain\Repository\CategoryRepository;

class ListCategoryUseCase
{
    public function __construct(
        protected CategoryRepository $repository,
    ) {
    }

    public function execute(?ListCategoryUseCaseInput $input = null): ListCategoryUseCaseOutput
    {
        $categoriesSearched = $this->repository->search(
            query: $input->filter ?? null
        );

        return ListCategoryUseCaseOutput::toOutput(
            items: $categoriesSearched->items,
            total: $categoriesSearched->total
        );
    }
}
