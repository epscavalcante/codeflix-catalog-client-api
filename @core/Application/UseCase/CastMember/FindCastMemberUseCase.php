<?php

namespace Core\Application\UseCase\CastMember;

use Core\Application\DTO\CastMember\CastMemberUseCaseOutput;
use Core\Application\DTO\CastMember\FindCastMemberUseCaseInput;
use Core\Domain\Repository\CastMemberRepository;
use Core\Domain\ValueObjects\CastMemberId;

class FindCastMemberUseCase
{
    public function __construct(
        protected CastMemberRepository $repository,
    ) {
    }

    public function execute(FindCastMemberUseCaseInput $input): CastMemberUseCaseOutput
    {
        $castMemberId = new CastMemberId($input->id);
        $castMemberFound = $this->repository->find($castMemberId);

        return CastMemberUseCaseOutput::fromEntity($castMemberFound);
    }
}
