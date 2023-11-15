<?php

namespace Core\Infra\Repository;

use Core\Domain\Entities\CastMember;
use Core\Domain\Exceptions\CastMemberNotFoundException;
use Core\Domain\Repository\CastMemberRepository;
use Core\Domain\Repository\CastMemberRepositorySearchResult;
use Core\Domain\ValueObjects\CastMemberId;
use Core\Infra\Contracts\ElasticsearchClientInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CastMemberElasticsearchRepository implements CastMemberRepository
{
    protected array $params = [];

    public function __construct(
        protected ElasticsearchClientInterface $elastichsearch,
    ) {
        $this->params['index'] = Config::get('services.elasticsearch.default_index').'.cast_members';
    }

    public function find(CastMemberId $id): CastMember
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
            throw new CastMemberNotFoundException($id);
        }

        return new CastMember(
            id: $id,
            name: $searchResult->items[0]['_source']['name'],
            type: $searchResult->items[0]['_source']['type'],
            createdAt: Carbon::parse($searchResult->items[0]['_source']['created_at'])
        );
    }

    /**
     * @return array CastMember
     */
    public function search(string $query = null): CastMemberRepositorySearchResult
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

        return new CastMemberRepositorySearchResult(
            total: $searchResponse->total,
            items: array_map(
                function ($item) {
                    return new CastMember(
                        id: new CastMemberId($item['_source']['id']),
                        name: $item['_source']['name'],
                        type: $item['_source']['type'],
                        createdAt: Carbon::parse($item['_source']['created_at'])
                    );
                },
                $searchResponse->items
            )
        );
    }
}
