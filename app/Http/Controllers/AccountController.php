<?php

namespace App\Http\Controllers;

use App\Dtos\UserDto;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(private readonly AccountService $accountService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request){
        $userDto = UserDto::fromModel($request->user());
        $account = $this->accountService->createAccountNumber($userDto);

        return $this->sendSuccess(['account' => $account], 'Account number created successfully!');
    }

    
}
