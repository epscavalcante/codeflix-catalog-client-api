<?php

use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\DTO\FindCategoryUseCaseOutput;
use Core\Application\DTO\ListCategoryUseCaseOutput;
use Core\Application\UseCase\FindCategoryUseCase;
use Core\Application\UseCase\ListCategoryUseCase;
use Core\Domain\Entities\Category;
use Core\Domain\Repository\CategoryRepository;
use Core\Infra\Repository\CategoryMemoryRepository;

afterAll(fn () => Mockery::close());

test('ListCategoryUseCaseTest', function () {
    // $id = Uuid::generate();

    // $mockCategory = Mockery::mock(Category::class, [
    //     'name' => 'Test',
    //     new Uuid($id),
    //     'description',
    //     true
    // ]);
    // $mockCategory->shouldReceive('id')->andReturn((string) $id);
    // $mockCategory->shouldReceive('id')->andReturn($id);
    // $input = new FindCategoryUseCaseInput(
    //     id: $id
    // );

    $mockRepository = Mockery::mock(CategoryRepository::class);
    $mockRepository->shouldReceive('search')
        ->times(1)
        ->andReturn([]);

    $useCase = new ListCategoryUseCase($mockRepository);
    $output = $useCase->execute();

    expect($output)->toBeInstanceOf(ListCategoryUseCaseOutput::class);
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
