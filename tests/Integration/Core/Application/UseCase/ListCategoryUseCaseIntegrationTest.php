<?php

namespace Tests\Integration\Core\Application\UseCase;

use Core\Application\DTO\ListCategoryUseCaseInput;
use Core\Application\DTO\ListCategoryUseCaseOutput;
use Core\Application\UseCase\ListCategoryUseCase;
use Core\Infra\ElasticsearchClientInterface;
use Core\Infra\Repository\CategoryElasticsearchRepository;
use Exception;
use Illuminate\Support\Facades\Config;

test('ListCategoryUseCaseIntegrationTest search', function (array $response) {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $elasticsearchClientStub = new class($response) implements ElasticsearchClientInterface
    {
        public function __construct(
            protected array $data
        ) {
        }

        public function search(array $params): array
        {
            return $this->data;
        }

        public function getIndices(): array
        {
            throw new Exception('Not implemented');
        }

        public function raw()
        {
            throw new Exception('Not implemented');
        }
    };

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
})->with('elasticdata');
