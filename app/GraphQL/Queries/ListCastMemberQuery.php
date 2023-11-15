<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Http\Resources\CastMemberResource;
use Core\Application\DTO\CastMember\ListCastMemberUseCaseInput;
use Core\Application\UseCase\CastMember\ListCastMemberUseCase;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ListCastMemberQuery extends Query
{
    protected $attributes = [
        'name' => 'ListCastMember',
    ];

    public function __construct(
        protected ListCastMemberUseCase $usecase
    ) {
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('CastMemberType'));
    }

    public function args(): array
    {
        return [
            'filter' => [
                'name' => 'filter',
                'type' => Type::string(),
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        $input = new ListCastMemberUseCaseInput(
            filter: $args['filter'] ?? null
        );
        $output = $this->usecase->execute($input);

        return array_map(
            fn ($item) => (new CastMemberResource($item))->resolve(),
            $output->items
        );
    }
}
