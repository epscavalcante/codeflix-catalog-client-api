<?php

namespace Core\Application\UseCase;

use Core\Application\DTO\CategoryUseCaseOutput;
use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Domain\Repository\CategoryRepository;

class FindCategoryUseCase
{
    public function __construct(
        protected CategoryRepository $repository,
    ) {
    }

    public function execute(FindCategoryUseCaseInput $input): CategoryUseCaseOutput
    {
        $categoryFound = $this->repository->find($input->id);

        return CategoryUseCaseOutput::fromEntity($categoryFound);
    }
}
