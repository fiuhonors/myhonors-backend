<?php

namespace MyHonors\Auth\Exception;

use \Exception;

class InvalidTokenException extends Exception 
{
    
    public function __construct($message = "", 
                                $code = 0, 
                                Exception $previous = null)
    {
        if (!$message) {
            $message = "The token has either expired or has "
                . "a corrupted payload.";
        }
        parent::__construct($message, $code, $previous);
    }
    
}