<?php

namespace App\Dtos;

use App\Enums\TransactionCategoryEnum;
use App\Http\Requests\RegisterUserRequest;
use App\Interfaces\DtoInterface;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class DepositDto
{
    private string $accountNumber;
    private int|float $amount;
    private string|null $description;
    private string $category;

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
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */ 
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return TransactionCategoryEnum::DEPOSIT->value;
    }

}
