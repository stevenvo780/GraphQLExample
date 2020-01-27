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

class UpdateArticleMutation extends Mutation
{
    protected $attributes = [
        'name' => 'articles',
        'description' => 'Crea un articulo'
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

    
    protected function rules(array $args = []): array
    { 
        return [
            'id' => ['required'],
            'title' => ['required'],
            'content' => ['required'],
            'user_id' => ['required']
        ];
    }
    
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
 
        if (isset($args['id'])) {
            $article = Article::where('id' , $args['id'])->get();
           
            if ($article)
            {
                $article = Article::findOrFail($args['id']);
                $article->fill($args);
                
                try {
                    $article->save();
                    if (isset($article->id)) {
                        return Article::where('id' , $article->id)->get();
                    } 
        
                } catch (\Throwable $th) {
                    return [];
                }
            }
           
        } 

        return Article::all();
    
    }
}
