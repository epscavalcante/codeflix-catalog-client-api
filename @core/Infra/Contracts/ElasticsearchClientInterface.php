<?php

namespace Core\Infra\Contracts;

interface ElasticsearchClientInterface
{
    public function search(array $params): SearchResult;

    public function getIndices(): array;

    public function raw();
}
