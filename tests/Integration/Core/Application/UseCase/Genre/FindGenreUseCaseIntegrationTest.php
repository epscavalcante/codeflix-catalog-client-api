<?php

namespace Tests\Integration\Core\Application\UseCase\Genre;

use Core\Application\DTO\Genre\FindGenreUseCaseInput;
use Core\Application\DTO\Genre\GenreUseCaseOutput;
use Core\Application\UseCase\Genre\FindGenreUseCase;
use Core\Domain\Exceptions\GenreNotFoundException;
use Core\Infra\Repository\GenreElasticsearchRepository;
use DateTime;
use Illuminate\Support\Facades\Config;
use Tests\Stubs\ElasticsearchClientStub;

Config::shouldReceive('get')
    ->with('services.elasticsearch.default_index')
    ->andReturn('index');

test('FindGenreUseCaseIntegrationTest ok', function () {
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: [
            [
                '_source' => [
                    'id' => '88bdf4aa-7ec7-408f-91f6-c82f192d540c',
                    'name' => 'Filme',
                    'categories_id' => [],
                    'created_at' => '2017-04-07T07:06:33+0000',
                ],
            ],
        ],
    );

    $repository = new GenreElasticsearchRepository($elasticsearchClientStub);
    $useCase = new FindGenreUseCase($repository);
    $input = new FindGenreUseCaseInput(
        id: '88bdf4aa-7ec7-408f-91f6-c82f192d540c'
    );
    $output = $useCase->execute(
        input: $input
    );
    expect($output)->toBeInstanceOf(GenreUseCaseOutput::class);
    expect($output->createdAt)->toBeInstanceOf(DateTime::class);
    expect($output->id)->toBeString()->toBe('88bdf4aa-7ec7-408f-91f6-c82f192d540c');
    expect($output->name)->toBeString()->toBe('Filme');
    expect($output->categoriesId)->toBeArray();
    expect($output->categoriesId)->toHavecount(0);
});

test('FindGenreUseCaseIntegrationTest not found', function () {
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: [],
    );

    $repository = new GenreElasticsearchRepository($elasticsearchClientStub);
    $useCase = new FindGenreUseCase($repository);
    $input = new FindGenreUseCaseInput(
        id: '88bdf4aa-7ec7-408f-91f6-c82f192d540c'
    );
    $useCase->execute(
        input: $input
    );
})->throws(GenreNotFoundException::class);
