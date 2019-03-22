<?php

namespace App\Exceptions;

use Exception;

class LimitException extends Exception
{
    public function __construct()
    {
        $this->code = 406;
        $this->message = '{"code":"406","message":"Buni qilishdan oldin tarif sotib oling!"}';
        
        response($this->getMessage(),$this->getCode())->header('Content-Type', 'application/json')->send() and die;

    }
}
