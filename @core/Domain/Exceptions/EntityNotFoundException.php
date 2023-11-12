<?php

namespace Core\Domain\Exceptions;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? 'Entity not found');
    }
}
