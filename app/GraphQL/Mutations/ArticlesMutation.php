<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use App\Article;
use App\User;
use GraphQl;

class ArticlesMutation extends Mutation
{
    protected $attributes = [
        'name' => 'article',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('article'));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'title' => ['name' => 'title', 'type' => Type::string()],
            'content' => ['name' => 'content', 'type' => Type::string()],
            'user_id' => ['name' => 'user_id', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $articulo = Article::find($args['id']);
        if($articulo)
        {
            $articulo->title = $args['title'];
            $articulo->content = $args['content'];
            $user = User::findOrFail($args['user_id']);
            $articulo->user = $user;
            $articulo->save();
            
        } else {
            $articulo = new Article();
            $articulo->title = $args['title'];
            $articulo->content = $args['content'];
            $user = User::findOrFail($args['user_id']);
            $articulo->user = $user;
            $articulo->save();
        } 

        return $articulo;
    }
}
