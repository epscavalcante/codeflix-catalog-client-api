<?php

namespace Core\Application\DTO\CastMember;

class ListCastMemberUseCaseOutput
{
    /**
     * @param  array<CastMemberUseCaseOutput>  $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $total,
    ) {
    }

    public static function toOutput(array $items, int $total): self
    {
        $castMembers = array_map(
            function ($castMember) {
                return CastMemberUseCaseOutput::fromEntity($castMember);
            },
            $items
        );

        return new self($castMembers, $total);
    }
}
