<?php

namespace Core\Domain\Repository;

use Core\Domain\Entities\CastMember;
use Core\Domain\ValueObjects\CastMemberId;

interface CastMemberRepository
{
    /**
     * @param  CastMemberId  $id  ID CastMember
     */
    public function find(CastMemberId $id): CastMember;

    public function search(string $query = null): CastMemberRepositorySearchResult;
}
