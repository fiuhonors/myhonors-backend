<?php

namespace MyHonors\Auth\Exception;

use \Exception;

class UninitializedTokenException extends Exception 
{
    
    public function __construct($message = "",
                                $code = 0, 
                                Exception $previous = null) 
    {
        if (!$message) {
            $message = "The token has not been initialized. " . 
                "Please initialize with initialize() or " . 
                "initializeManually()";   
        }
        parent::__construct($message, $code, $previous);
    }
    
}