<?php

namespace App\Exceptions;

use Exception;

class ThresholdException extends Exception
{
    //
    protected $message = "Error while setting currency threshold";
    protected $code = "THR_01";
}
