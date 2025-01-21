<?php

namespace App\Http\Controllers;

use App\Dtos\TransferDto;
use App\Http\Requests\TransferRequest;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function __construct(private readonly AccountService $accountService){}

    public function transfer(TransferRequest $request): JsonResponse{

        $user = $request->user();
        $senderAccount = $this->accountService->getAccountByUserId($user->id);

        $transferDto = $this->accountService->transfer(
            $senderAccount->account_number,
            $request->input('pin'),
            $request->input('receiver_account_number'),
            $request->input('amount'),
            $request->input('description'),
        );

        return $this->sendSuccess([], 'Transfer successful');
        


    }
}
