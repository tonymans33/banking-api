<?php

namespace App\Interfaces;

use App\Dtos\DepositDto;
use App\Dtos\UserDto;
use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;

interface AccountServiceInterface
{
    public function modelQuery(): Builder;
    public function createAccountNumber(UserDto $userDto): Account;
    public function getAccountByAccountNumber(string $accountNumber): Account;
    public function getAccountByUserId(int $userId): Account;
    public function getAccount(int|string $accountNumberOrId): Account;
    public function deposit(DepositDto $depositDto): void;
    public function accountExists(Builder $accountQuery): void;

}
