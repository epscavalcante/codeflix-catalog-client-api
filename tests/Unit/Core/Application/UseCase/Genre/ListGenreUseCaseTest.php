<?php

namespace Tests\Unit\Core\Application\UseCase;

use Core\Application\DTO\Genre\ListGenreUseCaseOutput;
use Core\Application\UseCase\Genre\ListGenreUseCase;
use Core\Domain\Entities\Genre;
use Core\Domain\Repository\GenreRepository;
use Core\Domain\Repository\GenreRepositorySearchResult;
use Core\Domain\ValueObjects\CategoryId;
use DateTime;
use Mockery;

afterAll(fn () => Mockery::close());

test('ListGenreUseCaseTest sem registros', function () {
    $filter = null;

    $mockRepository = Mockery::mock(GenreRepository::class);
    $mockRepository->shouldReceive('search')
        ->times(1)
        ->with($filter)
        ->andReturn(new GenreRepositorySearchResult(0, []));

    $useCase = new ListGenreUseCase($mockRepository);
    $output = $useCase->execute();

    expect($output)->toBeInstanceOf(ListGenreUseCaseOutput::class);
    expect($output->total)->toBe(0);
    expect($output->items)->toBeArray();
    expect($output->items)->toHaveCount(0);
});

test('ListCategoryUseCaseTest 2 registros', function () {
    $filter = null;
    $genres = [
        new Genre(
            name: 'Filme',
            categoriesId: [
                CategoryId::generate()
            ]
        ),
        new Genre(
            name: 'Documentário',
            categoriesId: [
                CategoryId::generate()
            ]
        ),
    ];

    $mockRepository = Mockery::mock(GenreRepository::class);
    $mockRepository->shouldReceive('search')
        ->times(1)
        ->with($filter)
        ->andReturn(new GenreRepositorySearchResult(2, $genres));

    $useCase = new ListGenreUseCase($mockRepository);
    $output = $useCase->execute($filter);

    expect($output)->toBeInstanceOf(ListGenreUseCaseOutput::class);
    expect($output->total)->toBe(2);
    expect($output->items)->toBeArray();
    expect($output->items)->toHaveCount(2);

    foreach ($output->items as $key => $genreOutput) {
        expect($genreOutput->id)->toBe((string) $genres[$key]->id);
        expect($genreOutput->name)->toBe($genres[$key]->name);
        expect($genreOutput->categoriesId)->toBeArray()->toHaveCount(1);
        expect($genreOutput->categoriesId[0])->toBe((string) $genres[$key]->categoriesId[0]);
        expect($genreOutput->createdAt)->toBeInstanceOf(DateTime::class);
    }
});
