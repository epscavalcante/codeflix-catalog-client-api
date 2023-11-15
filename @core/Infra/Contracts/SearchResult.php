<?php

namespace Core\Infra\Contracts;

class SearchResult
{
    public function __construct(
        public int $total,
        public array $items,
    ) {
    }
}
