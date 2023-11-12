<?php

namespace Core\Domain\Exceptions;

use Core\Domain\ValueObjects\CategoryId;

class CategoryNotFoundException extends EntityNotFoundException
{
    public function __construct(protected CategoryId $id)
    {
        $message = "Category not found using ID: " . (string) $id;

        parent::__construct($message);
    }
}
