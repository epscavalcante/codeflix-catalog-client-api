<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class GenreType extends GraphQLType
{
    protected $attributes = [
        'name' => 'GenreType',
        'description' => 'A type',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Genre ID',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Genre name',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Genre creation date',
            ],
        ];
    }
}
