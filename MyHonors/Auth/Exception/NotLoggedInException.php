<?php

namespace MyHonors\Auth;

use Exception;

class NotLoggedInException extends Exception
{
    
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        if (!$message) {
            $message = "You must be logged in to execute that action!";   
        }
        parent::construct($message, $code, $previous);
    }
    
}