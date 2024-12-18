<?php

namespace App\Services;

use App\Interfaces\UserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserService
{

    public function createUser(UserDto $userDto): Builder|Model
    {
        return User::query()->create([
            'name' => $userDto->getName(),
            'email' => $userDto->getEmail(),
            'phone_number' => $userDto->getPhone_number(),
            'password' => $userDto->getPassword(),
        ]);
    }
}
