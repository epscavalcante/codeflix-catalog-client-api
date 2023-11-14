<?php

namespace Tests\Integration\Core\Application\UseCase;

use Core\Application\DTO\CategoryUseCaseOutput;
use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\UseCase\FindCategoryUseCase;
use Core\Domain\Exceptions\CategoryNotFoundException;
use Core\Infra\Repository\CategoryElasticsearchRepository;
use DateTime;
use Illuminate\Support\Facades\Config;
use Tests\Stubs\ElasticsearchClientStub;

test('FindCategoryUseCaseIntegrationTest ok', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: [
            [
                '_source' => [
                    'id' => '88bdf4aa-7ec7-408f-91f6-c82f192d540c',
                    'name' => 'Yellow Tromp, Quigley and Auer',
                    'description' => null,
                    'is_active' => true,
                    'created_at' => '2017-04-07T07:06:33+0000',
                ],
            ],
        ],
    );

    $repository = new CategoryElasticsearchRepository($elasticsearchClientStub);
    $useCase = new FindCategoryUseCase($repository);
    $input = new FindCategoryUseCaseInput(
        id: '88bdf4aa-7ec7-408f-91f6-c82f192d540c'
    );
    $output = $useCase->execute(
        input: $input
    );
    expect($output)->toBeInstanceOf(CategoryUseCaseOutput::class);
    expect($output->createdAt)->toBeInstanceOf(DateTime::class);
    expect($output->id)->toBeString()->toBe('88bdf4aa-7ec7-408f-91f6-c82f192d540c');
    expect($output->name)->toBeString()->toBe('Yellow Tromp, Quigley and Auer');
});

test('FindCategoryUseCaseIntegrationTest not found', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: [],
    );

    $repository = new CategoryElasticsearchRepository($elasticsearchClientStub);
    $useCase = new FindCategoryUseCase($repository);
    $input = new FindCategoryUseCaseInput(
        id: '88bdf4aa-7ec7-408f-91f6-c82f192d540c'
    );
    $useCase->execute(
        input: $input
    );
})->throws(CategoryNotFoundException::class);
