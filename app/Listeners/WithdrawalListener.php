<?php

namespace App\Listeners;

use App\Enums\TransactionCategoryEnum;
use App\Events\TransactionEvent;
use App\Events\WithdrawalEvent;
use App\Services\TransactionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WithdrawalListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly TransactionService $transactionService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionEvent $event): void
    {

        if($event->transactionDto->getCategory() != TransactionCategoryEnum::WITHDRAWAL->value) {
            return;
        }

        $transaction = $this->transactionService->createTransaction($event->transactionDto);

        $account = $event->lockedAccount;
        $account->balance = $account->balance - $event->transactionDto->getAmount();
        $account->save();
        $account->refresh();

        $this->transactionService->updateTransactionBalance($event->transactionDto->getReference(), $account->balance);
        
        if($event->transactionDto->getTransferId()){
            $this->transactionService->updateTransferId($event->transactionDto->getReference(), $event->transactionDto->getTransferId());
        }
    }
}
