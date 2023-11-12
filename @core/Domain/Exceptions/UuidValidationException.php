<?php

namespace Core\Domain\Exceptions;

use Exception;

class UuidValidationException extends Exception
{
    public function __construct(protected string $id)
    {
        $message = "Uuid {$id} is not valid";

        parent::__construct($message);
    }
}
