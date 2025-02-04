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
    public function getTransactionByReference(string $reference): Transaction;
    public function getTransactionById(int $transactionId): Transaction;
    public function getTransactionsByAccountNumber(int $accountNumber, Builder $builder): Builder;
    public function getTransactionsByUserId(int $userId, Builder $builder): Builder;
    public function updateTransactionBalance(string $reference, float|int $balance): void;
}
