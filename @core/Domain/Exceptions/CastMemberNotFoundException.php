<?php

namespace Core\Domain\Exceptions;

use Core\Domain\ValueObjects\CastMemberId;

class CastMemberNotFoundException extends EntityNotFoundException
{
    public function __construct(protected CastMemberId $id)
    {
        $message = 'CastMember not found using ID: '.(string) $id;

        parent::__construct($message);
    }
}
