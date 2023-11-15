<?php

namespace Tests\Stubs;

use Core\Infra\Contracts\ElasticsearchClientInterface;
use Exception;

class ElasticsearchClientStub implements ElasticsearchClientInterface
{
    public function __construct(
        protected array $data
    ) {
    }

    public function search(array $params): array
    {
        return $this->data;
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
