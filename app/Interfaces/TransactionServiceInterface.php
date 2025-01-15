<?php

namespace App\Interfaces;

use App\Dtos\AccountDto;
use App\Dtos\DepositDto;
use App\Dtos\TransactionDto;
use App\Dtos\UserDto;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface TransactionServiceInterface
{
    public function modelQuery(): Builder;
    public function createTransaction(TransactionDto $transactionDto): Transaction;
    public function generateReference(): string;
    // public function getTransactionByReference(): Transaction;
    // public function getTransactionById(): Transaction;
    // public function getTransactionsByAccountNumber(): Builder;
    // public function getTransactionsByUserId(): Builder;
    // public function downloadTransactionHistory(AccountDto $accountDto, Carbon $fromDate, Carbon $endDate): Collection;
    public function updateTransactionBalance(string $reference, float|int $balance): void;


}
