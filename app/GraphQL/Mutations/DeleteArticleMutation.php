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

class DeleteArticleMutation extends Mutation
{
    protected $attributes = [
        'name' => 'articles',
        'description' => 'Borra un articulo'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
        ];
    }

    
    protected function rules(array $args = []): array
    { 
        return [
            'id' => ['required'],
          
        ];
    }
    
    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
 
        $user = Article::findOrFail($args['id']);
  
        return  $user->delete() ? true : false;
    
    }
}
