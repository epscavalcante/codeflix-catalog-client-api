<?php

namespace Core\Application\UseCase;

use Core\Application\DTO\CategoryUseCaseOutput;
use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Domain\Repository\CategoryRepository;
use Core\Domain\ValueObjects\CategoryId;

class FindCategoryUseCase
{
    public function __construct(
        protected CategoryRepository $repository,
    ) {
    }

    public function execute(FindCategoryUseCaseInput $input): CategoryUseCaseOutput
    {
        $categoryId = new CategoryId($input->id);
        $categoryFound = $this->repository->find($categoryId);

        return CategoryUseCaseOutput::fromEntity($categoryFound);
    }
}
