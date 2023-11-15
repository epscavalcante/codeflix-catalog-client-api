<?php

namespace Test\Unit\Core\Infra\Repository;

use App\Adapters\ElasticsearchClientAdapter;
use Core\Domain\Entities\Genre;
use Core\Domain\Exceptions\GenreNotFoundException;
use Core\Domain\Repository\GenreRepositorySearchResult;
use Core\Domain\ValueObjects\CategoryId;
use Core\Domain\ValueObjects\GenreId;
use Core\Infra\Contracts\SearchResult;
use Core\Infra\Repository\GenreElasticsearchRepository;
use DateTime;
use Illuminate\Support\Facades\Config;
use Mockery;

Config::shouldReceive('get')
    ->with('services.elasticsearch.default_index')
    ->andReturn('index');

afterAll(fn () => Mockery::close());

test('Search', function () {
    $mockElasticsearchClientAdapter = Mockery::mock(ElasticsearchClientAdapter::class);
    $mockElasticsearchClientAdapter->shouldReceive('search')
        ->times(1)
        ->andReturn(new SearchResult(0, []));

    $genreRepository = new GenreElasticsearchRepository($mockElasticsearchClientAdapter);
    $searchResponse = $genreRepository->search('test_name');
    expect($searchResponse)->toBeInstanceOf(GenreRepositorySearchResult::class);
});

test('Find: receives GenreNotFound', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');

    $genreId = GenreId::generate();

    $mockElasticsearchClientAdapter = Mockery::mock(ElasticsearchClientAdapter::class);
    $mockElasticsearchClientAdapter->shouldReceive('search')
        ->times(1)
        ->andReturn(new SearchResult(0, []));

    $genreRepository = new GenreElasticsearchRepository($mockElasticsearchClientAdapter);
    $genreRepository->find($genreId);
})->throws(GenreNotFoundException::class);

test('Find', function () {
    $id = '88bdf4aa-7ec7-408f-91f6-c82f192d540c';
    $categoryId = '0da40b28-8d45-3900-8334-7156568904ee';

    $mockElasticsearchClientAdapter = Mockery::mock(ElasticsearchClientAdapter::class);
    $mockElasticsearchClientAdapter->shouldReceive('search')
        ->times(1)
        ->andReturn(
            new SearchResult(
                total: 0,
                items: [
                    [
                        '_source' => [
                            'id' => $id,
                            'name' => 'Cat Name',
                            'categories_id' => [$categoryId],
                            'created_at' => '2018-01-01T15:20:11+0000',
                        ],
                    ],
                ]
            )
        );

    $genreRepository = new GenreElasticsearchRepository($mockElasticsearchClientAdapter);
    $genre = $genreRepository->find(new GenreId($id));

    expect($genre)->toBeInstanceOf(Genre::class);
    expect($genre->id)->toBeInstanceOf(GenreId::class);
    expect($genre->createdAt)->toBeInstanceOf(DateTime::class);
    expect($genre->categoriesId)->toBeArray();
    expect($genre->categoriesId[0])->toBeInstanceOf(CategoryId::class);
    expect((string) $genre->id)->toBe($id);
    expect($genre->name)->toBe('Cat Name');
    expect((string) $genre->categoriesId[0])->toBe($categoryId);
});
