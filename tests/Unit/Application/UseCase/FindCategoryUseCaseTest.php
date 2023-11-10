<?php

use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\DTO\FindCategoryUseCaseOutput;
use Core\Application\UseCase\FindCategoryUseCase;
use Core\Domain\Entities\Category;
use Core\Domain\Repository\CategoryRepository;
use Core\Domain\ValueObjects\Uuid;
use Core\Infra\Repository\CategoryMemoryRepository;

afterAll(fn () => Mockery::close());

test('FindCategoryUseCaseTest', function () {
    $id = Uuid::generate();

    $mockCategory = Mockery::mock(Category::class, [
        'name' => 'Test',
        new Uuid($id),
        'description',
        true
    ]);

    // $mockCategory->shouldReceive('id')->andReturn((string) $id);
    // $mockCategory->shouldReceive('id')->andReturn($id);
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

    expect($output)->toBeInstanceOf(FindCategoryUseCaseOutput::class);
});

test('FindCategoryUseCaseTest with MemoryRepository', function () {
    $category = new Category('Teste');
    $spy = Mockery::spy(CategoryMemoryRepository::class);
    $spy->shouldReceive('find');
    $spy->shouldHaveBeenCalled();
    $repository = new CategoryMemoryRepository();
    array_push($repository->items, $category);

    $input = new FindCategoryUseCaseInput(
        id: $category->id
    );

    $useCase = new FindCategoryUseCase(repository: $repository);
    $output = $useCase->execute(input: $input);

    expect($output)->toBeInstanceOf(FindCategoryUseCaseOutput::class);
})->skip('Pensar em como espiar o uso do repositorio de memória');
