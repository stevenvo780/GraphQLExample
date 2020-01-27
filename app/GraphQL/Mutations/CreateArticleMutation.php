<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use GraphQl;
use App\Article;

class CreateArticleMutation extends Mutation
{
    protected $attributes = [
        'name' => 'users',
        'description' => 'Crea un usuario'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('article'));
    }

    public function args(): array
    {
        return [
            'title' => ['name' => 'title', 'type' => Type::string()],
            'content' => ['name' => 'content', 'type' => Type::string()],
            'user_id' => ['name' => 'user_id', 'type' => Type::int()],
        ];
    }

    
    protected function rules(array $args = []): array
    { 
        return [
            'title' => ['required'],
            'content' => ['required'],
            'user_id' => ['required']
        ];
    }
    
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
 
        $article = new Article();
        $article->title = $args['title'];
        $article->content = $args['content'];
        $article->user_id = $args['user_id'];
        try {
            $article->save();
                    
            if (isset($article->id)) {
                return Article::where('id' , $article->id)->get();
            } 

        } catch (\Throwable $th) {
            return [];
        }
        
        return Article::all();
    
    }
}
