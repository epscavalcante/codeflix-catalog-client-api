<?php

namespace Core\Infra\Repository;

use Core\Domain\Entities\Category;
use Core\Domain\Exceptions\CategoryNotFoundException;
use Core\Domain\Repository\CategoryRepository;
use Core\Domain\Repository\CategoryRepositorySearchResult;
use Core\Domain\ValueObjects\CategoryId;
use Core\Infra\Contracts\ElasticsearchClientInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CategoryElasticsearchRepository implements CategoryRepository
{
    protected array $params = [];

    public function __construct(
        protected ElasticsearchClientInterface $elastichsearch,
    ) {
        $this->params['index'] = Config::get('services.elasticsearch.default_index').'.categories';
    }

    public function find(CategoryId $id): Category
    {
        $this->params['body'] = [
            'query' => [
                'match' => [
                    'id' => (string) $id,
                ],
            ],
        ];

        $response = $this->elastichsearch->search($this->params);

        if (count($response->items) === 0) {
            throw new CategoryNotFoundException($id);
        }

        return new Category(
            id: $id,
            name: $response->items[0]['_source']['name'],
            description: isset($response->items[0]['_source']['description']) ? $response->items[0]['_source']['description'] : null,
            isActive: $response->items[0]['_source']['is_active'],
            createdAt: Carbon::parse($response->items[0]['_source']['created_at'])
        );
    }

    public function search(string $query = null): CategoryRepositorySearchResult
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

        $searchResult = $this->elastichsearch->search($this->params);

        return new CategoryRepositorySearchResult(
            total: $searchResult->total,
            items: array_map(
                function ($item) {
                    return new Category(
                        id: new CategoryId($item['_source']['id']),
                        name: $item['_source']['name'],
                        description: isset($item['_source']['description']) ? $item['_source']['description'] : null,
                        isActive: $item['_source']['is_active'],
                        createdAt: Carbon::parse($item['_source']['created_at'])
                    );
                },
                $searchResult->items
            )
        );
    }
}
