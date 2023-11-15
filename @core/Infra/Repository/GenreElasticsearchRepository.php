<?php

namespace Core\Infra\Repository;

use Core\Domain\Entities\Genre;
use Core\Domain\Exceptions\GenreNotFoundException;
use Core\Domain\Repository\GenreRepository;
use Core\Domain\Repository\GenreRepositorySearchResult;
use Core\Domain\ValueObjects\CategoryId;
use Core\Domain\ValueObjects\GenreId;
use Core\Infra\Contracts\ElasticsearchClientInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class GenreElasticsearchRepository implements GenreRepository
{
    protected array $params = [];

    public function __construct(
        protected ElasticsearchClientInterface $elastichsearch,
    ) {
        $this->params['index'] = Config::get('services.elasticsearch.default_index').'.genres';
    }

    public function find(GenreId $id): Genre
    {
        $this->params['body'] = [
            'query' => [
                'match' => [
                    'id' => (string) $id,
                ],
            ],
        ];

        $searchResult = $this->elastichsearch->search($this->params);

        if (count($searchResult->items) === 0) {
            throw new GenreNotFoundException($id);
        }

        return new Genre(
            id: $id,
            name: $searchResult->items[0]['_source']['name'],
            categoriesId: array_map(fn ($categoryId) => new CategoryId($categoryId), $searchResult->items[0]['_source']['categories_id']),
            createdAt: Carbon::parse($searchResult->items[0]['_source']['created_at'])
        );
    }

    public function search(string $query = null): GenreRepositorySearchResult
    {
        if (isset($query) && $query !== '') {
            $this->params['body'] = [
                'query' => [
                    'match' => [
                        'name' => $query,
                    ],
                ],
            ];
        }

        $searchResponse = $this->elastichsearch->search($this->params);

        return new GenreRepositorySearchResult(
            total: $searchResponse->total,
            items: array_map(
                function ($item) {
                    return new Genre(
                        id: new GenreId($item['_source']['id']),
                        name: $item['_source']['name'],
                        categoriesId: array_map(fn ($categoryId) => new CategoryId($categoryId), $item['_source']['categories_id']),
                        createdAt: Carbon::parse($item['_source']['created_at'])
                    );
                },
                $searchResponse->items
            )
        );
    }
}
