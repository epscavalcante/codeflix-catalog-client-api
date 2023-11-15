<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Core\Application\DTO\CastMember\FindCastMemberUseCaseInput;
use Core\Application\UseCase\CastMember\FindCastMemberUseCase;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class FindCastMemberQuery extends Query
{
    protected $attributes = [
        'name' => 'FindCastMember',
    ];

    public function __construct(
        protected FindCastMemberUseCase $usecase
    ) {
    }

    public function type(): Type
    {
        return GraphQL::type('CastMemberType');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        $input = new FindCastMemberUseCaseInput(
            id: $args['id']
        );
        $output = $this->usecase->execute(
            input: $input
        );

        return $output;
    }
}
