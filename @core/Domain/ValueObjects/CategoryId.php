<?php

namespace Core\Domain\ValueObjects;

class CategoryId extends Uuid
{
    public static function generate(): self
    {
        return parent::generate();
    }
}
