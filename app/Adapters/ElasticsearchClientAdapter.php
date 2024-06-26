<?php

namespace App\Adapters;

use Core\Infra\Contracts\ElasticsearchClientInterface;
use Core\Infra\Contracts\SearchResult;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Config;

class ElasticsearchClientAdapter implements ElasticsearchClientInterface
{
    protected Client $elasticsearch;

    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts(Config::get('services.elasticsearch.hosts'))
            ->setBasicAuthentication(
                Config::get('services.elasticsearch.username'),
                Config::get('services.elasticsearch.password')
            )
            ->build();

        return $this->elasticsearch;
    }

    public function search(array $params): SearchResult
    {
        return $this->send($params);
    }

    public function getIndices(): array
    {
        $indices = json_decode(
            $this->elasticsearch->indices()->getMapping()->getBody(),
            true
        );

        return array_keys($indices);
    }

    public function raw(): Client
    {
        return $this->elasticsearch;
    }

    private function send(array $params = []): SearchResult
    {
        $response = $this->elasticsearch->search($params);
        $responseDecoded = json_decode($response->getBody(), true);

        return new SearchResult(
            total: $responseDecoded['hits']['total']['value'],
            items: $responseDecoded['hits']['hits']
        );
    }
}
