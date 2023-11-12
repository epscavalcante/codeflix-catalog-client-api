<?php

namespace Tests\Integration\Core\UseCase;

use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\UseCase\FindCategoryUseCase;
use Core\Infra\ElasticsearchClientInterface;
use Core\Infra\Repository\CategoryElasticsearchRepository;

test('FindCategoryUseCaseIntegrationTest', function () {
    $elasticsearchClentMock = new class implements ElasticsearchClientInterface
    {
        public function search(array $params): array
        {
            return [];
        }
    };

    $repository = new CategoryElasticsearchRepository($elasticsearchClentMock);
    $usecaseInput = new FindCategoryUseCaseInput(
        id: '1234'
    );
    $useCase = new FindCategoryUseCase($repository);

    dd($useCase->execute(
        input: $usecaseInput
    ));
    dd('teste');
})->skip('Todo');
