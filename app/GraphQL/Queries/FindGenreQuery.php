<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Http\Resources\GenreResource;
use Core\Application\DTO\Genre\FindGenreUseCaseInput;
use Core\Application\UseCase\Genre\FindGenreUseCase;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class FindGenreQuery extends Query
{
    protected $attributes = [
        'name' => 'FindGenre',
    ];

    public function __construct(
        protected FindGenreUseCase $usecase
    ) {
    }

    public function type(): Type
    {
        return GraphQL::type('GenreType');
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
        $input = new FindGenreUseCaseInput(
            id: $args['id']
        );

        $output = $this->usecase->execute(
            input: $input
        );

        return (new GenreResource($output))->resolve();
    }
}
