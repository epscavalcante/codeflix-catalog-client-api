<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Http\Resources\GenreResource;
use Core\Application\DTO\Genre\ListGenreUseCaseInput;
use Core\Application\UseCase\Genre\ListGenreUseCase;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ListGenreQuery extends Query
{
    protected $attributes = [
        'name' => 'ListGenre',
    ];

    public function __construct(
        protected ListGenreUseCase $usecase
    ) {
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('GenreType'));
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

    /**
     * @return array<GenreCategoryOutput>
     */
    public function resolve($root, array $args): array
    {
        $input = new ListGenreUseCaseInput(
            filter: $args['filter'] ?? null
        );
        $output = $this->usecase->execute($input);

        return array_map(
            fn ($item) => (new GenreResource($item))->resolve(),
            $output->items
        );
    }
}
