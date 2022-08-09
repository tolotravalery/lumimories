<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

interface IUserService
{
    public function save($user);

    public function getUserByEmail($email);

    public function getUserById($id);

    public function update(Request $request);
}
