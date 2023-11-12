<?php

namespace Core\Infra;

interface ElasticsearchClientInterface
{
    public function search(array $params): array;

    // Remover error de método não definido
    public function getIndices(): array;

    public function raw();
}
