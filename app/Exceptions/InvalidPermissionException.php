<?php

namespace App\Exceptions;

use Exception;

class InvalidPermissionException extends Exception
{
    public function __construct()
    {
        $this->code = 405;
        $this->message = '{"code":"405","message":"This User Has No Enough Priviliges To Execute The Command!"}';
        
        response($this->getMessage(),$this->getCode())->header('Content-Type', 'application/json')->send() and die;

    }
}
