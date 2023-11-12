<?php

namespace Tests\Unit\Core\Application\UseCase;

use Core\Application\DTO\CategoryUseCaseOutput;
use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\UseCase\FindCategoryUseCase;
use Core\Domain\Entities\Category;
use Core\Domain\Repository\CategoryRepository;
use Core\Domain\ValueObjects\CategoryId;
use DateTime;
use Mockery;

afterAll(fn () => Mockery::close());

test('FindCategoryUseCaseTest', function () {
    $id = new CategoryId('4682d903-2bce-4269-aa89-070ed0568209');
    $createdAt = new DateTime();

    $mockCategory = new Category(
        id: $id,
        name: 'Test',
        isActive: false,
        description: null,
        createdAt: $createdAt
    );

    $input = new FindCategoryUseCaseInput(
        id: $id
    );

    $mockRepository = Mockery::mock(CategoryRepository::class);
    $mockRepository->shouldReceive('find')
        ->times(1)
        ->with($input->id)
        ->andReturn($mockCategory);

    $useCase = new FindCategoryUseCase($mockRepository);
    $output = $useCase->execute(input: $input);

    expect($output)->toBeInstanceOf(CategoryUseCaseOutput::class);
    expect($output->id)->toBe('4682d903-2bce-4269-aa89-070ed0568209');
    expect($output->name)->toBe('Test');
    expect($output->description)->toBeNull();
    expect($output->isActive)->toBeFalse();
    expect($output->createdAt)->toBeInstanceOf(DateTime::class);
});
