<?php

namespace Tests\Unit\Core\Application\UseCase;

use Core\Application\DTO\ListCategoryUseCaseOutput;
use Core\Application\UseCase\ListCategoryUseCase;
use Core\Domain\Entities\Category;
use Core\Domain\Repository\CategoryRepository;
use Core\Domain\Repository\CategoryRepositorySearchResult;
use Core\Domain\ValueObjects\CategoryId;
use DateTime;
use Mockery;

afterAll(fn () => Mockery::close());

test('ListCategoryUseCaseTest sem registros', function () {
    $filter = null;

    $mockRepository = Mockery::mock(CategoryRepository::class);
    $mockRepository->shouldReceive('search')
        ->times(1)
        ->with($filter)
        ->andReturn(new CategoryRepositorySearchResult(0, []));

    $useCase = new ListCategoryUseCase($mockRepository);
    $output = $useCase->execute();

    expect($output)->toBeInstanceOf(ListCategoryUseCaseOutput::class);
    expect($output->total)->toBe(0);
    expect(count($output->items))->toBe(0);
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
        ),
    ];

    $mockRepository = Mockery::mock(CategoryRepository::class);
    $mockRepository->shouldReceive('search')
        ->times(1)
        ->with($filter)
        ->andReturn(new CategoryRepositorySearchResult(2, $categories));

    $useCase = new ListCategoryUseCase($mockRepository);
    $output = $useCase->execute($filter);

    expect($output)->toBeInstanceOf(ListCategoryUseCaseOutput::class);
    expect($output->items)->toBeArray();
    expect($output->total)->toBe(2);
    expect($output->items)->toHaveCount(2);

    foreach ($output->items as $key => $categoryOutput) {
        expect($categoryOutput->id)->toBeString()->toBe((string) $categories[$key]->id);
        expect($categoryOutput->name)->toBeString()->toBe($categories[$key]->name);
        expect($categoryOutput->isActive)->toBeBool()->toBe($categories[$key]->isActive);
        expect($categoryOutput->createdAt)->toBeInstanceOf(DateTime::class);
    }
});
