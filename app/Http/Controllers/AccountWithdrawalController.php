<?php

namespace App\Http\Controllers;

use App\Dtos\WithdrawDto;
use App\Http\Requests\WithdrawRequest;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountWithdrawalController extends Controller
{
    public function __construct(private readonly AccountService $accountService){}

    /**
     * Handle the withdrawal request.
     *
     * @param WithdrawRequest $withdrawRequest
     * @return \Illuminate\Http\Response
     */
    public function withdraw(WithdrawRequest $withdrawRequest): JsonResponse
    {
        // Create a new WithdrawDto instance
        $withdrawDto = new WithdrawDto();
        
        // Retrieve the account associated with the authenticated user
        $account = $this->accountService->getAccountByUserId($withdrawRequest->user()->id);

        // Set the account number, amount, description, and pin for the withdrawal
        $withdrawDto->setAccountNumber($account->account_number);
        $withdrawDto->setAmount($withdrawRequest->get('amount'));
        $withdrawDto->setDescription($withdrawRequest->get('description'));
        $withdrawDto->setPin($withdrawRequest->get('pin'));

        // Perform the withdrawal operation
        $this->accountService->withdraw($withdrawDto);

        // Return a success response
        return $this->sendSuccess([], 'Withdraw successful!');
    }
}
