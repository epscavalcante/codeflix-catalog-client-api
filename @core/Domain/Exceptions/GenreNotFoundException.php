<?php

namespace Core\Domain\Exceptions;

use Core\Domain\ValueObjects\GenreId;

class GenreNotFoundException extends EntityNotFoundException
{
    public function __construct(protected GenreId $id)
    {
        $message = 'Genre not found using ID: '.(string) $id;

        parent::__construct($message);
    }
}
