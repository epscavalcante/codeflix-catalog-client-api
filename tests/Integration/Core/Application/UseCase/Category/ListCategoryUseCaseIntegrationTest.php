<?php

namespace Tests\Integration\Core\Application\UseCase\Category;

use Core\Application\DTO\ListCategoryUseCaseInput;
use Core\Application\DTO\ListCategoryUseCaseOutput;
use Core\Application\UseCase\ListCategoryUseCase;
use Core\Infra\Repository\CategoryElasticsearchRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Tests\Stubs\ElasticsearchClientStub;

test('ListCategoryUseCaseIntegrationTest search', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $categories = json_decode(file_get_contents(storage_path('app/mocks/categories.json'), true), true);
    $data = Arr::map($categories, function ($item) {
        return [
            '_source' => [
                'id' => $item['id'],
                'name' => $item['name'],
                'description' => $item['description'],
                'is_active' => $item['is_active'],
                'created_at' => $item['created_at'],
            ]
        ];
    });
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: $data,
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
    expect($output->items)->toBeArray();
    expect($output->total)->toBeInt();
});
