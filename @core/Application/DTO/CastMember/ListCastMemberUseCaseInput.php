<?php

namespace Core\Application\DTO\CastMember;

class ListCastMemberUseCaseInput
{
    public function __construct(
        public readonly ?string $filter = null
    ) {
    }
}
