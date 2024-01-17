<?php

namespace Tests\Integration\Core\Application\UseCase\Genre;

use Core\Application\DTO\Genre\ListGenreUseCaseInput;
use Core\Application\DTO\Genre\ListGenreUseCaseOutput;
use Core\Application\UseCase\Genre\ListGenreUseCase;
use Core\Infra\Repository\GenreElasticsearchRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Tests\Stubs\ElasticsearchClientStub;

test('ListGenreUseCaseIntegrationTest search', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $genres = json_decode(file_get_contents(storage_path('app/mocks/genres.json'), true), true);
    $data = Arr::map($genres, function ($item) {
        return [
            '_source' => [
                'id' => $item['id'],
                'name' => $item['name'],
                'categories_id' => $item['categories_id'],
                'created_at' => $item['created_at'],
            ]
        ];
    });
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: $data,
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
    expect($output->items)->toHaveCount(count($data));
    expect($output->total)->toBeInt();
});
