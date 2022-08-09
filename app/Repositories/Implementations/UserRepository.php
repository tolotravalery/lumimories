<?php

namespace App\Repositories\Implementations;

use App\Models\User;
use App\Repositories\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{

    public function getUserByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }

    public function save($user)
    {
        return User::create([
            'email' => $user->email,
            'password' => Hash::make($user->password),
            'name' => $user->name,
            'prenom' => $user->prenom
        ]);
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }
}
