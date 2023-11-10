<?php

namespace Core\Application\UseCase;

use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\DTO\FindCategoryUseCaseOutput;
use Core\Domain\Repository\CategoryRepository;

class FindCategoryUseCase
{
    public function __construct(
        protected CategoryRepository $repository,
    ) {
    }

    public function execute(FindCategoryUseCaseInput $input): FindCategoryUseCaseOutput
    {
        $categoryFound = $this->repository->find($input->id);

        return FindCategoryUseCaseOutput::fromEntity($categoryFound);
    }
}
