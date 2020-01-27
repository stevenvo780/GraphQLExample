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

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'Actualizar usuario',
        'description' => 'Actualiza un usuario'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'password' => ['name' => 'password', 'type' => Type::string()],
        ];
    }

    protected function rules(array $args = []): array
    { 
        return [
            'id' => ['required'],
            'email' => ['required'],
            'name' => ['required'],
            'password' => ['required']
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        
        if (isset($args['id'])) {
            $user = User::where('id' , $args['id'])->get();
           
            if ($user)
            {
                $user = User::findOrFail($args['id']);
                $user->fill($args);
                
                try {
                    $user->save();
                    if (isset($user->id)) {
                        return User::where('id' , $user->id)->get();
                    } 
        
                } catch (\Throwable $th) {
                    return [];
                }
            }
           
        } 

        return User::all();
    }
}
