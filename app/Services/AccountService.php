<?php

namespace App\Services;

use App\Dtos\AccountDto;
use App\Dtos\DepositDto;
use App\Dtos\TransactionDto;
use App\Events\DepositEvent;
use App\Interfaces\AccountServiceInterface;
use App\Models\Account;
use App\Dtos\UserDto;
use App\Exceptions\AccountNumberExistsException;
use App\Exceptions\AmountToLowException;
use App\Exceptions\InvalidAccountNumberException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AccountService implements AccountServiceInterface
{

    public function __construct(private readonly UserService $userService, private readonly TransactionService $transactionService) {}
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

    /**
     * @param DepositDto $depositDto
     * @return Account
    */
    public function deposit(DepositDto $depositDto): void
    {
        $minimumAmount = 500;
        if($depositDto->getAmount() < $minimumAmount) {
            throw new AmountToLowException($minimumAmount);
        }

        try{
            DB::beginTransaction();
            $transactionDto = new TransactionDto();

            $accountQuery = $this->modelQuery()->where('account_number', $depositDto->getAccountNumber());
            $this->accountExists($accountQuery);
            $lockedAccount = $accountQuery->lockForUpdate()->first();

            $accountDto = AccountDto::fromModel($lockedAccount);
            $transactionDto = $transactionDto->forDeposit($accountDto, $this->transactionService->generateReference(), $depositDto->getAmount(), $depositDto->getDescription());

            event(new DepositEvent($transactionDto, $accountDto, $lockedAccount));
            DB::commit();
            

        } catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Throws an exception if the account number does not exist
     * @param Builder $accountQuery
     * @throws InvalidAccountNumberException
     */
    public function accountExists(Builder $accountQuery): void{
        if($accountQuery->exists() == false){
            throw new InvalidAccountNumberException();
        }
    }
}
