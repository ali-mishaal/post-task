<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function createUser($data): User;

    public function getUserByEmail($email): User;
}
