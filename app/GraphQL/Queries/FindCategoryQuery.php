<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use Core\Application\DTO\FindCategoryUseCaseInput;
use Core\Application\UseCase\FindCategoryUseCase;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;

class FindCategoryQuery extends Query
{
    protected $attributes = [
        'name' => 'FindCategory',
    ];

    public function __construct(
        protected FindCategoryUseCase $usecase
    ) {
    }

    public function type(): Type
    {
        return GraphQL::type('CategoryType');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::string(),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, array $args)
    {
        $input = new FindCategoryUseCaseInput(
            id: $args['id']
        );
        $output = $this->usecase->execute(
            input: $input
        );

        return $output;
    }
}
