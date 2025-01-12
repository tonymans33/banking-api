<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class PinController extends Controller
{
    public function setupPin(Request $request, UserService $userService){

        $this->validate($request, [
            'pin' => ['required',' string', 'min:4', 'max:4']
        ]);

        $user = $request->user();
        $userService->setPin($user, $request->pin);

        return $this->sendSuccess([], 'Pin set successfully!');
    }

    public function validatePin(Request $request, UserService $userService){

        $this->validate($request, [
            'pin' => ['required',' string', 'min:4', 'max:4']
        ]);

        $user = $request->user();
        $isValid = $userService->validatePin($user->id, $request->pin);

        return $this->sendSuccess(['isValid' => $isValid], 'Pin validated successfully!');
    }
}
