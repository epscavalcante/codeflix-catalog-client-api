<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CastMemberType extends GraphQLType
{
    protected $attributes = [
        'name' => 'CastMemberType',
        'description' => 'A type',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'CastMember ID',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'CastMember name',
            ],
            'type' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'CastMember Type',
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'CastMember creation date',
            ],
        ];
    }
}
