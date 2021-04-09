<?php

namespace App\Exceptions;

use Exception;

class BaseCurrencyException extends Exception
{
    //
    protected $message = "Error while setting base currency";
    protected $code = "BCUR_01";
}
