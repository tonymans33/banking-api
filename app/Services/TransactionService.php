<?php 

namespace App\Services;

use App\Dtos\AccountDto;
use App\Dtos\TransactionDto;
use App\Enums\TransactionCategoryEnum;
use App\Interfaces\TransactionServiceInterface;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
class TransactionService implements TransactionServiceInterface
{
    public function createTransaction(TransactionDto $transactionDto): Transaction
    {
        $data = [];
        if($transactionDto->getCategory() == TransactionCategoryEnum::DEPOSIT->value){
            $data = $transactionDto->forDepositToArray($transactionDto);
        }
        if($transactionDto->getCategory() == TransactionCategoryEnum::WITHDRAWAL->value){
            $data = [];
        }
        $transaction = $this->modelQuery()->create($data);
        return $transaction;
    }

    // public function getTransactionByReference(): Transaction
    // {
    //     // implementation for getting a transaction by reference
    // }

    // public function getTransactionById(): Transaction
    // {
    //     // implementation for getting a transaction by ID
    // }

    // public function getTransactionsByAccountNumber(): Builder
    // {
    //     // implementation for getting transactions by account number
    // }

    // public function getTransactionsByUserId(): Builder
    // {
    //     // implementation for getting transactions by user ID
    // }

    // public function downloadTransactionHistory(AccountDto $accountDto, Carbon $fromDate, Carbon $endDate): Collection
    // {
    //     // implementation for downloading transaction history
    // }
    public function generateReference(): string{
        return Str::upper('TF'.'/'. Carbon::now()->getTimestampMs(). '/'. Str::random(4));
    }

    public function modelQuery(): Builder{
        return Transaction::query();
    }

    public function updateTransactionBalance(string $reference, float|int $balance): void{
        $this->modelQuery()->where('reference', $reference)->update(['balance' => $balance, 'confirmed' => true]);
    }




}