<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Interfaces\UserDto;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function __construct(private readonly UserService $userService) {}

    public function register(RegisterUserRequest $request): JsonResponse
    {
        // User::create([]);
        $userDto = UserDto::fromApiFormRequest($request);
        $user = $this->userService->createUser($userDto);

        return $this->sendSuccess(['user' => $user], 'User created successfully');
    }
}
