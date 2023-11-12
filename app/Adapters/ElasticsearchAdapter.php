<?php

namespace App\Adapters;

use Core\Infra\ElasticsearchClientInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Config;

class ElasticsearchAdapter implements ElasticsearchClientInterface
{
    protected Client $elasticsearch;

    public function __construct() {
        $this->elasticsearch = ClientBuilder::create()
                ->setHosts([Config::get('services.elasticsearch.hosts')])
                ->setBasicAuthentication(
                    Config::get('services.elasticsearch.username'),
                    Config::get('services.elasticsearch.password')
                )
                ->build();

        return $this->elasticsearch;
    }

    public function search(array $params): array
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

    private function send(array $params = []): array
    {
        $response = $this->elasticsearch->search($params);
        $responseDecoded = json_decode($response->getBody(), true);

        return $responseDecoded['hits']['hits'];
    }
}
