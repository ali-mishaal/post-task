<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function createUser($data): User
    {
        $data['password'] = bcrypt(Str::random(10));

        return User::create($data);
    }

    public function getUserByEmail($email): User
    {
        return User::where('email', $email)->first();
    }
}
