<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Core\Application\DTO\ListCategoryUseCaseInput;
use Core\Application\UseCase\ListCategoryUseCase;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ListCategoryQuery extends Query
{
    protected $attributes = [
        'name' => 'ListCategory',
    ];

    public function __construct(
        protected ListCategoryUseCase $usecase
    ) {
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('CategoryType'));
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
        $input = new ListCategoryUseCaseInput(
            filter: $args['filter'] ?? null
        );
        $output = $this->usecase->execute($input);

        return $output->categories;
    }
}
