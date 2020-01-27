<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use GraphQl;
use App\User;

class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'Borrar usuario',
        'description' => 'Borra un usuario'
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
        $user = User::findOrFail($args['id']);
  
        return  $user->delete() ? true : false;
    }
}
