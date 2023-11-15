<?php

namespace Tests\Unit\Core\Application\UseCase;

use Core\Application\DTO\Genre\FindGenreUseCaseInput;
use Core\Application\DTO\Genre\GenreUseCaseOutput;
use Core\Application\UseCase\Genre\FindGenreUseCase;
use Core\Domain\Entities\Genre;
use Core\Domain\Repository\GenreRepository;
use Core\Domain\ValueObjects\CategoryId;
use Core\Domain\ValueObjects\GenreId;
use DateTime;
use Mockery;

afterAll(fn () => Mockery::close());

test('FindGenreUseCaseTest', function () {
    $id = new GenreId('4682d903-2bce-4269-aa89-070ed0568209');
    $categoriesId = [
        CategoryId::generate(),
        CategoryId::generate(),
    ];
    $createdAt = new DateTime();

    $mockGenre = new Genre(
        id: $id,
        name: 'Test',
        categoriesId: $categoriesId,
        createdAt: $createdAt
    );

    $input = new FindGenreUseCaseInput(
        id: (string) $id
    );

    $mockRepository = Mockery::mock(GenreRepository::class);
    $mockRepository->shouldReceive('find')
        ->times(1)
        ->andReturn($mockGenre);

    $useCase = new FindGenreUseCase($mockRepository);
    $output = $useCase->execute(input: $input);

    expect($output)->toBeInstanceOf(GenreUseCaseOutput::class);
    expect($output->id)->toBe('4682d903-2bce-4269-aa89-070ed0568209');
    expect($output->name)->toBe('Test');
    expect($output->categoriesId)->toBeArray();
    expect($output->categoriesId)->toHaveCount(2);
    expect($output->categoriesId[0])->toBe((string) $categoriesId[0]);
    expect($output->categoriesId[1])->toBe((string) $categoriesId[1]);
    expect($output->createdAt)->toBeInstanceOf(DateTime::class);
});
