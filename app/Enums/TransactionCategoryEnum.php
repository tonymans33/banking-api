<?php

namespace App\Enums;

enum TransactionCategoryEnum: string
{
    case WITHDRAWAL = 'withdrawal';
    case DEPOSIT = 'deposit';
}
