<?php

namespace App\Dtos;

use App\Enums\TransactionCategoryEnum;
use App\Http\Requests\RegisterUserRequest;
use App\Interfaces\DtoInterface;
use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class AccountDto
{
    private int $id;
    private int $userId;
    private float $balance;
    private string $accountNumber;
    private Carbon $createdAt;
    private Carbon $updatedAt;



    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }


    /**
     * Get the value of balance
     */ 
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set the value of balance
     *
     * @return  self
     */ 
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get the value of accountNumber
     */ 
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set the value of accountNumber
     *
     * @return  self
     */ 
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public static function fromModel(Model|Account $lockedAccount): self{
        
        $dto = new self();
        $dto->setId($lockedAccount->id)
            ->setAccountNumber($lockedAccount->account_number)
            ->setBalance($lockedAccount->balance)
            ->setUserId($lockedAccount->user_id);

        return $dto;
    }

}

