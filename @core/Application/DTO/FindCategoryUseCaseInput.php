<?php

namespace Core\Application\DTO;

class FindCategoryUseCaseInput
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
