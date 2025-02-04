<?php

namespace App\Http\Controllers;

use App\Dtos\UserDto;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(private readonly UserService $userService) {}



    /**
     * Handle an authentication attempt.
     *
     * @param  \App\Http\Requests\RegisterUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $userDto = UserDto::fromApiFormRequest($request);
        $user = $this->userService->createUser($userDto);

        return $this->sendSuccess(['user' => $user], 'User created successfully');
    }

    public function login(LoginUserRequest $request): JsonResponse
    {

        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return $this->sendError('The provided credentials are incorrect!');
        }

        $user = $request->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendSuccess(['user' => $user, 'token' => $token], 'User logged in successfully');
    }

    public function user(Request $request)
    {
        return $this->sendSuccess([
            'user' => $request->user(),
        ], 'Authenticated user retrieved successfully!');
    }

    public function logout(Request $request)
    {

        $user = $request->user();
        $user->tokens()->delete();

        return $this->sendSuccess([], 'User logged out successfully!');
    }
}
