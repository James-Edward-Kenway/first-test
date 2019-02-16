<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct()
    {
        $this->code = 401;
        $this->message = '{"code":"401","message":"User is unauthorized!"}';
        
        response($this->getMessage(),$this->getCode())->header('Content-Type', 'application/json')->send() and die;
    }
}
