<?php
namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQl\Type\Definition\Type;
use App\Article;
use GraphQl;

class ArticleType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Article',
        'description' => 'A type',
        'model' => Article::class,
    ];

    public function fields() : array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id del Articulo',
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'titulo de articulo',
            ],
            'content' => [
                'type' => Type::string(),
                'description' => 'titulo de articulo',
            ],
            'user' => [
                'type' => GraphQl::type('user'),
                'description' => 'Usuario del artiuclo',
            ]
        ];

    }
}