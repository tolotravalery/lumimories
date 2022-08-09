<?php

namespace App\Repositories;

use App\Models\User;

interface IUserRepository
{
    public function getUserByEmail($email);

    public function save($user);

    public function getUserById($id);
}
