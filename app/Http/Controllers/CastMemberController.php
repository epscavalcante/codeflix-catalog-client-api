<?php

namespace App\Http\Controllers;

use App\Http\Resources\CastMemberResource;
use Core\Application\DTO\CastMember\FindCastMemberUseCaseInput;
use Core\Application\DTO\CastMember\ListCastMemberUseCaseInput;
use Core\Application\UseCase\CastMember\FindCastMemberUseCase;
use Core\Application\UseCase\CastMember\ListCastMemberUseCase;
use Illuminate\Http\Request;

class CastMemberController extends Controller
{
    public function __construct()
    {
    }

    public function search(Request $request, ListCastMemberUseCase $listCastMemberUseCase)
    {
        $input = new ListCastMemberUseCaseInput(
            filter: $request->get('q')
        );
        $output = $listCastMemberUseCase->execute(
            input: $input
        );

        return CastMemberResource::collection($output->items)
            ->additional([
                'total' => $output->total,
            ]);
    }

    public function find(string $castMemberId, FindCastMemberUseCase $findCastMemberUseCase)
    {
        $input = new FindCastMemberUseCaseInput($castMemberId);
        $output = $findCastMemberUseCase->execute($input);

        return new CastMemberResource($output);
    }
}
