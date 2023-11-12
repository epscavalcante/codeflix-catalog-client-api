<?php

namespace Tests\Unit\Core\Application\UseCase;

use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\DTO\FindCategoryUseCaseOutput;
use Core\Application\DTO\ListCategoryUseCaseOutput;
use Core\Application\UseCase\FindCategoryUseCase;
use Core\Application\UseCase\ListCategoryUseCase;
use Core\Domain\Entities\Category;
use Core\Domain\Repository\CategoryRepository;
use Core\Domain\ValueObjects\CategoryId;
use Core\Infra\Repository\CategoryMemoryRepository;
use Database\Factories\CategoryFactory;
use DateTime;
use Mockery;

afterAll(fn () => Mockery::close());

test('ListCategoryUseCaseTest sem registros', function () {
    $filter = null;

    $mockRepository = Mockery::mock(CategoryRepository::class);
    $mockRepository->shouldReceive('search')
        ->times(1)
        ->with($filter)
        ->andReturn([]);

    $useCase = new ListCategoryUseCase($mockRepository);
    $output = $useCase->execute();

    expect($output)->toBeInstanceOf(ListCategoryUseCaseOutput::class);
    expect(count($output->categories))->toBe(0);
});

test('ListCategoryUseCaseTest 2 registros', function () {
    $filter = null;
    $categories = [
        new Category(
            id: CategoryId::generate(),
            name: 'Category 1'
        ),
        new Category(
            id: CategoryId::generate(),
            name: 'Category 2'
        )
    ];

    $mockRepository = Mockery::mock(CategoryRepository::class);
    $mockRepository->shouldReceive('search')
        ->times(1)
        ->with($filter)
        ->andReturn($categories);

    $useCase = new ListCategoryUseCase($mockRepository);
    $output = $useCase->execute($filter);

    expect($output)->toBeInstanceOf(ListCategoryUseCaseOutput::class);
    expect($output->categories)->toBeArray();
    expect($output->categories)->toHaveCount(2);

    foreach($output->categories as $key => $categoryOutput) {
        expect($categoryOutput->id)->toBeString()->toBe((string) $categories[$key]->id);
        expect($categoryOutput->name)->toBeString()->toBe($categories[$key]->name);
        expect($categoryOutput->isActive)->toBeBool()->toBe($categories[$key]->isActive);
        expect($categoryOutput->createdAt)->toBeInstanceOf(DateTime::class);
    }
});
