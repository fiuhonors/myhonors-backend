<?php

namespace MyHonors\Auth\Contract;

interface AuthSpecificInterface 
{
    
    /**
    * Log the user in using a concrete auth implementation
    * @param string $username Username
    * @param string $password Password
    * @return boolean TRUE on success, FALSE on failure
    */
    public function login($username, $password);
    
    /**
    * Gets the logged-in user's information
    * @return \MyHonors\Auth\Contract\UserInterface
    */
    public function getUser();
    
}