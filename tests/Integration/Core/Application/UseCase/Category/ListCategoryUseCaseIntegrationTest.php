<?php

namespace Tests\Integration\Core\Application\UseCase\Category;

use Core\Application\DTO\ListCategoryUseCaseInput;
use Core\Application\DTO\ListCategoryUseCaseOutput;
use Core\Application\UseCase\ListCategoryUseCase;
use Core\Infra\Repository\CategoryElasticsearchRepository;
use Illuminate\Support\Facades\Config;
use Tests\Stubs\ElasticsearchClientStub;

test('ListCategoryUseCaseIntegrationTest search', function (array $response) {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: $response,
    );

    $repository = new CategoryElasticsearchRepository($elasticsearchClientStub);
    $useCase = new ListCategoryUseCase($repository);
    $input = new ListCategoryUseCaseInput(
        filter: null
    );
    $output = $useCase->execute(
        input: $input
    );

    expect($output)->toBeInstanceOf(ListCategoryUseCaseOutput::class);
    expect($output->categories)->toBeArray();
    expect($output->categories)->toHaveCount(count($response));
})->with('elasticdata.categories');
