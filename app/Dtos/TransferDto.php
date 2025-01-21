<?php

namespace App\Dtos;

class TransferDto
{
    private ?int $id;
    private int $senderId;
    private int $senderAccountId;
    private int $recipientId;
    private int $recipientAccountId;
    private string $reference;
    private string $status;
    private float $amount;
    private string $createdAt;
    private string $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getSenderId(): int
    {
        return $this->senderId;
    }

    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    public function getSenderAccountId(): int
    {
        return $this->senderAccountId;
    }

    public function setSenderAccountId(int $senderAccountId): void
    {
        $this->senderAccountId = $senderAccountId;
    }

    public function getRecipientId(): int
    {
        return $this->recipientId;
    }

    public function setRecipientId(int $recipientId): void
    {
        $this->recipientId = $recipientId;
    }

    public function getRecipientAccountId(): int
    {
        return $this->recipientAccountId;
    }

    public function setRecipientAccountId(int $recipientAccountId): void
    {
        $this->recipientAccountId = $recipientAccountId;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
