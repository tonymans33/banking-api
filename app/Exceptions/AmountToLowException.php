<?php

namespace App\Exceptions;

use Exception;

class AmountToLowException extends Exception
{
    public function __construct($amount)
    {
        parent::__construct("Amount must be greater than {$amount}");
    }
}
