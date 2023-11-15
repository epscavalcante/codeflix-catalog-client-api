<?php

namespace Core\Domain\Repository;

use Core\Domain\Entities\CastMember;

class CastMemberRepositorySearchResult
{
    /**
     * @param  array<CastMember>  $items
     */
    public function __construct(
        public int $total,
        public array $items,
    ) {
    }
}
