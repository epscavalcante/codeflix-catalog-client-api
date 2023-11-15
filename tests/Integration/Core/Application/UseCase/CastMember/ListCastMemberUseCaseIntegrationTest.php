<?php

namespace Tests\Integration\Core\Application\UseCase;

use Core\Application\DTO\CastMember\ListCastMemberUseCaseInput;
use Core\Application\DTO\CastMember\ListCastMemberUseCaseOutput;
use Core\Application\UseCase\CastMember\ListCastMemberUseCase;
use Core\Infra\Repository\CastMemberElasticsearchRepository;
use Illuminate\Support\Facades\Config;
use Tests\Stubs\ElasticsearchClientStub;

test('ListCastMemberUseCaseIntegrationTest search', function (array $response) {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: $response,
    );

    $repository = new CastMemberElasticsearchRepository($elasticsearchClientStub);
    $useCase = new ListCastMemberUseCase($repository);
    $input = new ListCastMemberUseCaseInput(
        filter: null
    );
    $output = $useCase->execute(
        input: $input
    );

    expect($output)->toBeInstanceOf(ListCastMemberUseCaseOutput::class);
    expect($output->items)->toBeArray();
    expect($output->items)->toHaveCount(count($response));
})->with('elasticdata.cast_members');
