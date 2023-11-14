<?php

namespace Test\Unit\Core\Infra\Repository;

use App\Adapters\ElasticsearchClientAdapter;
use Core\Domain\Entities\Category as EntitiesCategory;
use Core\Domain\Exceptions\CategoryNotFoundException;
use Core\Domain\ValueObjects\CategoryId;
use Core\Infra\Repository\CategoryElasticsearchRepository;
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
        ->andReturn([]);

    $categoryRepository = new CategoryElasticsearchRepository($mockElasticsearchClientAdapter);
    $response = $categoryRepository->search('test_name');
    expect($response)->toBeArray();
});

test('Find: receives CategoryNotFound', function () {
    Config::shouldReceive('get')
        ->with('services.elasticsearch.default_index')
        ->andReturn('index');

    $categoryId = CategoryId::generate();

    $mockElasticsearchClientAdapter = Mockery::mock(ElasticsearchClientAdapter::class);
    $mockElasticsearchClientAdapter->shouldReceive('search')
        ->times(1)
        ->andReturn([]);

    $categoryRepository = new CategoryElasticsearchRepository($mockElasticsearchClientAdapter);
    $categoryRepository->find($categoryId);
})->throws(CategoryNotFoundException::class);

test('Find', function () {
    $id = '88bdf4aa-7ec7-408f-91f6-c82f192d540c';

    $mockElasticsearchClientAdapter = Mockery::mock(ElasticsearchClientAdapter::class);
    $mockElasticsearchClientAdapter->shouldReceive('search')
        ->times(1)
        ->andReturn([
            [
                '_source' => [
                    'id' => $id,
                    'name' => 'Cat Name',
                    'description' => 'Desc',
                    'is_active' => true,
                    'created_at' => '2023-12-12 12:12:00',
                ],
            ],
        ]);

    $categoryRepository = new CategoryElasticsearchRepository($mockElasticsearchClientAdapter);
    $category = $categoryRepository->find(new CategoryId($id));
    expect($category)->toBeInstanceOf(EntitiesCategory::class);
    expect($category->id)->toBeInstanceOf(CategoryId::class);
    expect($category->createdAt)->toBeInstanceOf(DateTime::class);
    expect((string) $category->id)->toBe($id);
    expect($category->name)->toBe('Cat Name');
    expect($category->description)->toBe('Desc');
    expect($category->isActive)->toBeTrue();
});
