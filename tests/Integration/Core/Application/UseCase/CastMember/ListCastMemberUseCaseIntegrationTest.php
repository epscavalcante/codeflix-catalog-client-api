<?php

namespace Tests\Integration\Core\Application\UseCase;

use Core\Application\DTO\CastMember\ListCastMemberUseCaseInput;
use Core\Application\DTO\CastMember\ListCastMemberUseCaseOutput;
use Core\Application\UseCase\CastMember\ListCastMemberUseCase;
use Core\Infra\Repository\CastMemberElasticsearchRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\Stubs\ElasticsearchClientStub;

// dd($castMembers);
test('ListCastMemberUseCaseIntegrationTest search', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');
    $castMembers = json_decode(file_get_contents(storage_path('app/mocks/cast-members.json'), true), true);
    $data = Arr::map($castMembers, function ($item) {
        return [
            '_source' => [
                'id' => $item['id'],
                'name' => $item['name'],
                'type' => $item['type'],
                'created_at' => $item['created_at'],
            ]
        ];
    });
    $elasticsearchClientStub = new ElasticsearchClientStub(
        data: $data,
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
    expect($output->items)->toHaveCount(count($data));
    expect($output->total)->toBeInt();
});
