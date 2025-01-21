<?php

namespace App\Dtos;

use App\Enums\TransactionCategoryEnum;
use App\Interfaces\DtoInterface;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class TransactionDto
{
    private ?int $id;
    private string $reference;
    private int $userId;
    private int $accountId;
    private ?int $transferId;
    private float $amount;
    private float $balance;
    private string $category;
    private bool $confirmed;
    private ?string $description;
    private Carbon $date;
    private ?string $metal;
    private ?Carbon $createdAt;
    private ?Carbon $updatedAt;

    /**
     * Getters and Setters for all properties
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): self
    {
        $this->accountId = $accountId;
        return $this;
    }

    public function getTransferId(): ?int
    {
        return $this->transferId;
    }

    public function setTransferId(?int $transferId): self
    {
        $this->transferId = $transferId;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function setDate(Carbon $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getMetal(): ?string
    {
        return $this->metal;
    }

    public function setMetal(?string $metal): self
    {
        $this->metal = $metal;
        return $this;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?Carbon $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?Carbon $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Creates a new TransactionDto object for a deposit transaction
     *
     * @param AccountDto $accountDto The account to which the deposit is being made
     * @param float|int $amount The amount of the deposit
     * @param string|null $description A description of the deposit
     * @return TransactionDto The created TransactionDto object
     */
    public function forDeposit(AccountDto $accountDto, string $reference, float|int $amount, string|null $description): TransactionDto
    {
        $dto = new TransactionDto();

        $dto->setUserId($accountDto->getUserId())
            ->setReference($reference)
            ->setAccountId($accountDto->getId())
            ->setAmount($amount)
            ->setCategory(TransactionCategoryEnum::DEPOSIT->value)
            ->setDate(Carbon::now())
            ->setTransferId(null)
            ->setDescription($description);

        return $dto;
    }

    public function forDepositToArray(TransactionDto $transactionDto): array
    {
        return [
            'user_id' => $transactionDto->getUserId(),
            'reference' => $transactionDto->getReference(),
            'account_id' => $transactionDto->getAccountId(),
            'amount' => $transactionDto->getAmount(),
            'category' => $transactionDto->getCategory(),
            'date' => $transactionDto->getDate(),
            'description' => $transactionDto->getDescription(),
        ];
    }

    public function forWithdrawal(AccountDto $accountDto, string $reference, WithdrawDto $withdrawDto): TransactionDto
    {
        $dto = new TransactionDto();

        $dto->setUserId($accountDto->getUserId())
            ->setReference($reference)
            ->setAccountId($accountDto->getId())
            ->setAmount($withdrawDto->getAmount())
            ->setDate(Carbon::now())
            ->setCategory($withdrawDto->getCategory())
            ->setTransferId(null)
            ->setDescription($withdrawDto->getDescription());

        return $dto;
    }

    public function forWithdrawalToArray(TransactionDto $transactionDto): array
    {
        return [
            'user_id' => $transactionDto->getUserId(),
            'reference' => $transactionDto->getReference(),
            'account_id' => $transactionDto->getAccountId(),
            'amount' => $transactionDto->getAmount(),
            'category' => $transactionDto->getCategory(),
            'date' => $transactionDto->getDate(),
            'description' => $transactionDto->getDescription(),
        ];
    }
    // /**
    //  * Create TransactionDto from Model
    //  */
    // public static function fromModel(Transaction|Model $model): TransactionDto
    // {
    //     $dto = new self();

    //     $dto->setId($model->id)
    //         ->setReference($model->reference)
    //         ->setUserId($model->user_id)
    //         ->setAccountId($model->account_id)
    //         ->setTransferId($model->transfer_id)
    //         ->setAmount($model->amount)
    //         ->setBalance($model->balance)
    //         ->setCategory($model->category)
    //         ->setConfirmed($model->confirmed)
    //         ->setDescription($model->description)
    //         ->setDate(new Carbon($model->date))
    //         ->setMetal($model->metal)
    //         ->setCreatedAt($model->created_at)
    //         ->setUpdatedAt($model->updated_at);

    //     return $dto;
    // }

    // /**
    //  * Convert Model to Array
    //  */
    // public static function toArray(Transaction|Model $model): array
    // {
    //     return [
    //         'id' => $model->id,
    //         'reference' => $model->reference,
    //         'user_id' => $model->user_id,
    //         'account_id' => $model->account_id,
    //         'transfer_id' => $model->transfer_id,
    //         'amount' => $model->amount,
    //         'balance' => $model->balance,
    //         'category' => $model->category,
    //         'confirmed' => $model->confirmed,
    //         'description' => $model->description,
    //         'date' => $model->date,
    //         'metal' => $model->metal,
    //         'created_at' => $model->created_at,
    //         'updated_at' => $model->updated_at,
    //     ];
    // }
}
