<?php

namespace App\Exceptions;

use Exception;

class signupException extends Exception
{
    protected $message = "Error while creating user";
    protected $code = "SIGNUP_01";
}
