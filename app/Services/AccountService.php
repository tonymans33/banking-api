<?php

namespace App\Services;

use App\Interfaces\AccountServiceInterface;
use App\Models\Account;
use App\Dtos\UserDto;
use App\Exceptions\AccountNumberExistsException;
use Illuminate\Database\Eloquent\Builder;

class AccountService implements AccountServiceInterface
{

    public function __construct(private readonly UserService $userService) {}
    public function modelQuery(): Builder
    {
        return Account::query();
    }

    public function hasAccountNumber(UserDto $userDto): bool
    {
        return $this->modelQuery()->where('user_id', $userDto->getId())->exists();
    }

    public function createAccountNumber(UserDto $userDto): Account
    {
        if ($this->hasAccountNumber($userDto)) {
            throw new AccountNumberExistsException();
        }
        return $this->modelQuery()->create([
            'user_id' => $userDto->getId(),
            'account_number' => substr($userDto->getPhoneNumber(), -10),
        ]);
    }

    public function getAccount(int|string $accountNumberOrId): Account
    {
        return $this->modelQuery()->where('account_number', $accountNumberOrId)->orWhere('id', $accountNumberOrId)->first();
    }

    public function getAccountByAccountNumber(string $accountNumber): Account
    {
        return $this->modelQuery()->where('account_number', $accountNumber)->first();
    }

    public function getAccountByUserId(int $userId): Account
    {
        return $this->modelQuery()->where('user_id', $userId)->first();
    }
}
