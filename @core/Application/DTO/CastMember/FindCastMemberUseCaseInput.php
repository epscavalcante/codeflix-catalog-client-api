<?php

namespace Core\Application\DTO\CastMember;

class FindCastMemberUseCaseInput
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
