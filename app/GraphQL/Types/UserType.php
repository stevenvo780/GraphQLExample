<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\User;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'A type',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id del Articulo',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'nombre de articulo'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'email de articulo',
                'resolve' => function($root, $args) {
                    // If you want to resolve the field yourself, 
                    // it can be done here
                    return strtolower($root->email);
                }
            ],
            'isMe' => [
                'type' => Type::boolean(),
                'description' => 'True, if the queried user is the current user',
                'selectable' => false, // Does not try to query this from the database
            ]

        ];

    }
    protected function resolveEmailField($root, $args)
    {
        return strtolower($root->email);
    } 
}