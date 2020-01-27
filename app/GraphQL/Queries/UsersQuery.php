<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL;
use App\User;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'user',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id' , 'type' => Type::int()],
            'email' => ['name' => 'email' , 'type' => Type::string()],
        ];
    }

    public function resolve($root, $args, $context, SelectFields $fields, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
       
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        if(isset($args['id']))
        {
            return User::where('id','=',$args['id'])->get();
        }

        if (isset($args['email'])) {
            return User::where('email', $args['email'])->get();
        }

        $users = User::with($with)->select($select)->get();

        return $users;
    }
}
