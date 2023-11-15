<?php

namespace Test\Unit\Core\Infra\Repository;

use App\Adapters\ElasticsearchClientAdapter;
use Core\Domain\Entities\CastMember;
use Core\Domain\Exceptions\CastMemberNotFoundException;
use Core\Domain\Repository\CastMemberRepositorySearchResult;
use Core\Domain\ValueObjects\CastMemberId;
use Core\Infra\Contracts\SearchResult;
use Core\Infra\Repository\CastMemberElasticsearchRepository;
use DateTime;
use Illuminate\Support\Facades\Config;
use Mockery;

afterAll(fn () => Mockery::close());

test('Search', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');

    $mockElasticsearchClientAdapter = Mockery::mock(ElasticsearchClientAdapter::class);
    $mockElasticsearchClientAdapter->shouldReceive('search')
        ->times(1)
        ->andReturn(new SearchResult(0, []));

    $castMemberRepository = new CastMemberElasticsearchRepository($mockElasticsearchClientAdapter);
    $response = $castMemberRepository->search('test_name');
    expect($response)->toBeInstanceOf(CastMemberRepositorySearchResult::class);
});

test('Find: receives CastMemberNotFound', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');

    $castMemberId = CastMemberId::generate();

    $mockElasticsearchClientAdapter = Mockery::mock(ElasticsearchClientAdapter::class);
    $mockElasticsearchClientAdapter->shouldReceive('search')
        ->times(1)
        ->andReturn(new SearchResult(0, []));

    $castMemberRepository = new CastMemberElasticsearchRepository($mockElasticsearchClientAdapter);
    $castMemberRepository->find($castMemberId);
})->throws(CastMemberNotFoundException::class);

test('Find', function () {
    $id = '88bdf4aa-7ec7-408f-91f6-c82f192d540c';

    $mockElasticsearchClientAdapter = Mockery::mock(ElasticsearchClientAdapter::class);
    $mockElasticsearchClientAdapter->shouldReceive('search')
        ->times(1)
        ->andReturn(new SearchResult(1, [
            [
                '_source' => [
                    'id' => $id,
                    'name' => 'Diretor',
                    'type' => 1,
                    'created_at' => '2023-12-12 12:12:00',
                ],
            ],
        ]));

    $castMemberRepository = new CastMemberElasticsearchRepository($mockElasticsearchClientAdapter);
    $castMember = $castMemberRepository->find(new CastMemberId($id));
    expect($castMember)->toBeInstanceOf(CastMember::class);
    expect($castMember->id)->toBeInstanceOf(CastMemberId::class);
    expect($castMember->createdAt)->toBeInstanceOf(DateTime::class);
    expect((string) $castMember->id)->toBe($id);
    expect($castMember->name)->toBe('Diretor');
    expect($castMember->type)->toBe(1);
});
