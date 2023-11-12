<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'CategoryType',
        'description' => 'A type',
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Category ID'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Category name'
            ],
            'is_active' => [
                'type' => Type::boolean(),
                'description' => 'Category isActive?'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Category description'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Category creation date'
            ],
        ];
    }
}
