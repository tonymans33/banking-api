<?php

namespace App\Services;

use App\Dtos\TransactionDto;
use App\Enums\TransactionCategoryEnum;
use App\Interfaces\TransactionServiceInterface;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TransactionService implements TransactionServiceInterface
{
    public function createTransaction(TransactionDto $transactionDto): Transaction
    {
        $data = [];
        if ($transactionDto->getCategory() == TransactionCategoryEnum::DEPOSIT->value) {
            $data = $transactionDto->forDepositToArray($transactionDto);
        }
        if ($transactionDto->getCategory() == TransactionCategoryEnum::WITHDRAWAL->value) {
            $data = $transactionDto->forWithdrawalToArray($transactionDto);
        }
        $transaction = $this->modelQuery()->create($data);
        return $transaction;
    }

    public function getTransactionByReference(string $reference): Transaction
    {
        $transaction = $this->modelQuery()->where('reference', $reference)->first();
        if (!$transaction) {
            throw new Exception("transaction with the requested reference not found");
        }

        return $transaction;
    }

    public function getTransactionById(int $transactionId): Transaction
    {
        $transaction = $this->modelQuery()->find($transactionId);
        if (!$transaction) {
            throw new Exception("transaction with the requested id not found");
        }

        return $transaction;
    }

    public function getTransactionsByAccountNumber(int $accountNumber, Builder $builder): Builder
    {
        return $builder->whereHas('account', fn(Builder $query) => $query->where('account_number', $accountNumber));
    }

    public function getTransactionsByUserId(int $userId, Builder $builder): Builder
    {
        return $builder->where('user_id', $userId);
    }


    public function generateReference(): string
    {
        return Str::upper('TF' . '/' . Carbon::now()->getTimestampMs() . '/' . Str::random(4));
    }

    public function modelQuery(): Builder
    {
        return Transaction::query();
    }

    public function updateTransactionBalance(string $reference, float|int $balance): void
    {
        $this->modelQuery()->where('reference', $reference)->update(['balance' => $balance, 'confirmed' => true]);
    }

    public function updateTransferId(string $reference, int $transferId): void
    {
        $this->modelQuery()->where('reference', $reference)->update(['transfer_id' => $transferId]);
    }
}
