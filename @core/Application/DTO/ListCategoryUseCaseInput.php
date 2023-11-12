<?php

namespace Core\Application\DTO;

class ListCategoryUseCaseInput
{
    public function __construct(
        public readonly ?string $filter = null
    ) {
    }
}
