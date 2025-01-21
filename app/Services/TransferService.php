<?php 

namespace App\Services;

use App\Dtos\AccountDto;
use App\Dtos\TransferDto;
use App\Exceptions\NotFoundException;
use App\Interfaces\TransferServiceInterface;
use App\Models\Transfer;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TransferService implements TransferServiceInterface
{
    public function modelQuery(): Builder
    {
        return Transfer::query();
    }

    public function createTransfer(TransferDto $transferDto): Transfer
    {
        return Transfer::create([
            'sender_id' => $transferDto->getSenderId(),
            'sender_account_id' => $transferDto->getSenderAccountId(),
            'recipient_id' => $transferDto->getRecipientId(),
            'recipient_account_id' => $transferDto->getRecipientAccountId(),
            'reference' => $transferDto->getReference(),
            'status' => $transferDto->getStatus(),
            'amount' => $transferDto->getAmount(),
        ]);
    }

    public function getTransfersBetweenAccount(AccountDto $firstAccountDto, AccountDto $secondAccountDto): array
    {
        return [];
        // return $this->modelQuery()
        //     ->where(function ($query) use ($firstAccountDto, $secondAccountDto) {
        //         $query->where('sender_account_id', $firstAccountDto->getId())
        //               ->where('recipient_account_id', $secondAccountDto->getId());
        //     })
        //     ->orWhere(function ($query) use ($firstAccountDto, $secondAccountDto) {
        //         $query->where('sender_account_id', $secondAccountDto->getId())
        //               ->where('recipient_account_id', $firstAccountDto->getId());
        //     })
        //     ->get()
        //     ->toArray();
    }

    public function generateReference(): string
    {
        return Str::upper('TRF-' . Carbon::now()->getTimestampMs() . '-' . Str::random(4));
    }

    public function getTransferById(int $transferId): Transfer
    {
        $transfer = $this->modelQuery()->where('id', $transferId)->first();
        if (!$transfer) {
            throw new Exception('Transfer not found');
        }
        return $transfer;
    }

    public function getTransferByReference(string $reference): Transfer
    {
        $transfer = $this->modelQuery()->where('reference', $reference)->first();
        if (!$transfer) {
            throw new Exception('Transfer not found');
        }
        return $transfer;
    }
}
