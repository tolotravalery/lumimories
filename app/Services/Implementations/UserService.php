<?php

namespace App\Services\Implementations;

use App\Models\User;
use App\Repositories\IUserRepository;
use App\Services\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService implements IUserService
{
    private $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save($user)
    {
        return $this->repository->save($user);
    }

    public function getUserByEmail($email)
    {
        return $this->repository->getUserByEmail($email);
    }

    public function getUserById($id)
    {
        return $this->repository->getUserById($id);
    }

    public function validator(array $data)
    {
        return Validator::make($data,
            [
                'email' => [ 'email', 'max:255'],
                'password' => ['confirmed'],
            ]
        );
    }

    public function update(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->getUserById($request->input("id"));
        $user->name = $request->input("name");
        $user->prenom = $request->input("prenom");
        $user->email = $request->input("email");
        if($request->input("password") != null){
            $user->password = Hash::make($request->input("password"));
        }
        $user->save();
        return $user;
    }
}
