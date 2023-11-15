<?php

namespace Tests\Integration\Core\Application\UseCase\Genre;

use Core\Application\DTO\Genre\ListGenreUseCaseInput;
use Core\Application\DTO\Genre\ListGenreUseCaseOutput;
use Core\Application\UseCase\Genre\ListGenreUseCase;
use Core\Infra\Repository\GenreElasticsearchRepository;
use Illuminate\Support\Facades\Config;
use Tests\Stubs\ElasticsearchClientStub;

test('ListGenreUseCaseIntegrationTest search', function (array $response) {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: $response,
    );

    $repository = new GenreElasticsearchRepository($elasticsearchClientStub);
    $useCase = new ListGenreUseCase($repository);
    $input = new ListGenreUseCaseInput(
        filter: null
    );
    $output = $useCase->execute(
        input: $input
    );

    expect($output)->toBeInstanceOf(ListGenreUseCaseOutput::class);
    expect($output->items)->toBeArray();
    expect($output->total)->toBeInt();
})->with('elasticdata.genres');
