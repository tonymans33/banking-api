<?php

namespace App\Services;

use App\Dtos\UserDto;
use App\Exceptions\InvalidPinLengthException;
use App\Exceptions\PinHasAlreadyBeenSetException;
use App\Exceptions\PinNotSetException;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class UserService implements UserServiceInterface
{

    public function createUser(UserDto $userDto): Builder|Model
    {
        return User::query()->create([
            'name' => $userDto->getName(),
            'email' => $userDto->getEmail(),
            'phone_number' => $userDto->getPhoneNumber(),
            'password' => $userDto->getPassword(),
        ]);
    }

    public function getUserById(int $userId): Builder|Model{

        $user = User::query()->where('id', $userId)->first();
        if(!$user){
            throw new ModelNotFoundException("User not found!");
        } 

        return $user;
    }

    public function setPin(User $user, string $pin): void
    {
        if($this->hasSetPin($user)){
            throw new PinHasAlreadyBeenSetException("Pin already set!");
        }

        if(strlen($pin) !== 4){
            throw new InvalidPinLengthException();
        }

        $user->pin = Hash::make($pin);
        $user->save();
    }

    public function validatePin(int $userId, string $pin): bool
    {
        $user = $this->getUserById($userId);

        if(!$this->hasSetPin($user)){
            throw new PinNotSetException("Please set your pin first!");
        }
        return Hash::check($pin, $user->pin);
    }

    public function hasSetPin(User $user): bool
    {
        return $user->pin !== null;
    }

}
