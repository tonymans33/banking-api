<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Interfaces\UserDto;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function register(RegisterUserRequest $request): JsonResponse
    {

        $userDto = UserDto::fromApiFormRequest($request);
        $user = $this->userService->createUser($userDto);

        return response()->json([
            'user' => $user,
            'success' => true, 
            'message' => 'User Registered Successfully !'
        ]);
    }
}
