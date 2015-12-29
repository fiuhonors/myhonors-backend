<?php

namespace MyHonors\Auth\Contract;

/**
* Authentication Driver - actual login mechanism that logs the user in 
*   with the provided username and password information.
*/
interface AuthDriverInterface 
{
    
    /**
    * Log the user in using a concrete auth implementation
	* @throws \Exception If the user cannot be logged in because 
    *   of errors not concerning user credentials 
    *   e.g. network errors
    * @return boolean TRUE on success, FALSE on failure
    */
    public function login();
    
    /**
    * Logs the user out. This should clear the object as if it 
    *   wasn't event initialized by the login method to begin with
    * @throws \Exception If the user cannot be logged out
    * @return boolean TRUE on success, FALSE on failure
    */
    public function logout();
    
    /**
    * Gets the logged-in user's information
	* @throws \MyHonors\Auth\Exception\NotLoggedInException
    * @return \MyHonors\Auth\Contract\AuthUserInterface
    */
    public function getUser();
    
}