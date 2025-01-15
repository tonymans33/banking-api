<?php 

namespace App\Dtos;

use App\Enums\TransactionCategoryEnum;

class WithdrawDto {

    private string $accountNumber;
    private int|float $amount;
    private string|null $description;
    private string $pin;
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
        $this->setCategory(TransactionCategoryEnum::WITHDRAWAL->value);
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * Get the value of pin
     */ 
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set the value of pin
     *
     * @return  self
     */ 
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

}