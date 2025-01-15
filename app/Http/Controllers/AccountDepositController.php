<?php

namespace App\Http\Controllers;

use App\Dtos\DepositDto;
use App\Http\Requests\DepositRequest;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountDepositController extends Controller
{
    public function __construct(private readonly AccountService $accountService){}

    public function deposit(DepositRequest $depositRequest){

        $depositDto = new DepositDto();
        $depositDto->setAccountNumber($depositRequest->get('account_number'));
        $depositDto->setAmount($depositRequest->get('amount'));
        $depositDto->setDescription($depositRequest->get('description'));

        $this->accountService->deposit($depositDto);
        return $this->sendSuccess([], 'Deposit successful!');

    }
}
