<?php

namespace Core\Application\UseCase\CastMember;

use Core\Application\DTO\CastMember\ListCastMemberUseCaseInput;
use Core\Application\DTO\CastMember\ListCastMemberUseCaseOutput;
use Core\Domain\Repository\CastMemberRepository;

class ListCastMemberUseCase
{
    public function __construct(
        protected CastMemberRepository $repository,
    ) {
    }

    public function execute(?ListCastMemberUseCaseInput $input = null): ListCastMemberUseCaseOutput
    {
        $searchResult = $this->repository->search(
            query: $input->filter ?? null
        );

        return ListCastMemberUseCaseOutput::toOutput(
            items: $searchResult->items,
            total: $searchResult->total
        );
    }
}
