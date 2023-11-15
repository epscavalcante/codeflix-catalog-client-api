<?php

namespace Tests\Integration\Core\Application\UseCase;

use Core\Application\DTO\CastMember\CastMemberUseCaseOutput;
use Core\Application\DTO\CastMember\FindCastMemberUseCaseInput;
use Core\Application\UseCase\CastMember\FindCastMemberUseCase;
use Core\Domain\Exceptions\CastMemberNotFoundException;
use Core\Infra\Repository\CastMemberElasticsearchRepository;
use DateTime;
use Illuminate\Support\Facades\Config;
use Tests\Stubs\ElasticsearchClientStub;

test('FindCastMemberUseCaseIntegrationTest ok', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: [
            [
                '_source' => [
                    'id' => '88bdf4aa-7ec7-408f-91f6-c82f192d540c',
                    'name' => 'Diretor',
                    'type' => 1,
                    'created_at' => '2017-04-07T07:06:33+0000',
                ],
            ],
        ],
    );

    $repository = new CastMemberElasticsearchRepository($elasticsearchClientStub);
    $useCase = new FindCastMemberUseCase($repository);
    $input = new FindCastMemberUseCaseInput(
        id: '88bdf4aa-7ec7-408f-91f6-c82f192d540c'
    );
    $output = $useCase->execute(
        input: $input
    );
    expect($output)->toBeInstanceOf(CastMemberUseCaseOutput::class);
    expect($output->createdAt)->toBeInstanceOf(DateTime::class);
    expect($output->id)->toBeString()->toBe('88bdf4aa-7ec7-408f-91f6-c82f192d540c');
    expect($output->name)->toBeString()->toBe('Diretor');
});

test('FindCastMemberUseCaseIntegrationTest not found', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: [],
    );

    $repository = new CastMemberElasticsearchRepository($elasticsearchClientStub);
    $useCase = new FindCastMemberUseCase($repository);
    $input = new FindCastMemberUseCaseInput(
        id: '88bdf4aa-7ec7-408f-91f6-c82f192d540c'
    );
    $useCase->execute(
        input: $input
    );
})->throws(CastMemberNotFoundException::class);
