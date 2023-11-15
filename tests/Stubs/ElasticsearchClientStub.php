<?php

namespace Tests\Stubs;

use Core\Infra\Contracts\ElasticsearchClientInterface;
use Core\Infra\Contracts\SearchResult;
use Exception;

class ElasticsearchClientStub implements ElasticsearchClientInterface
{
    public function __construct(
        protected array $data
    ) {
    }

    public function search(array $params): SearchResult
    {
        return new SearchResult(count($this->data), $this->data);
    }

    public function getIndices(): array
    {
        throw new Exception('Not implemented');
    }

    public function raw()
    {
        throw new Exception('Not implemented');
    }
}
