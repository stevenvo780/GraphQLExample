<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL;
use App\Article;

class ArticlesQuery extends Query
{
    protected $attributes = [
        'name' => 'articles',
        'description' => 'A query'
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
        ];
    }

    public function resolve($root, $args, $context,SelectFields $fields, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
    
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if(isset($args['id']))
        {
            return Article::findOrFail($args['id']);
        }

        $article = Article::all();

        return $article;
    }
}
