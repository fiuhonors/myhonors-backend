<?php

namespace MyHonors\Auth\Contract;

/**
* Authentication Factory is the "public" interface that is used to 
*   generally authenticate a user in. External modules should typically 
*   not touch any other class inside the Auth module besides this.
*/
interface AuthFactoryInterface 
{
    
    /**
    * Logs a user in by use of credentials
    * @param string $username Username of user to log in
    * @param string $password Password of user to log in
    * @return boolean TRUE on success, FALSE on failure
    */
    public function loginByCredentials(
        $username,
        $password
    );
    
    /**
    * Logs a user in by use of a token
    * @param string $authToken Token of a user to log in
    * @return boolean TRUE on success, FALSE on failure
    */
    public function loginByToken($authToken);
    
    /**
    * Checks if a user is logged in or not
    * @return boolean TRUE if there is a logged in user, 
    *   FALSE otherwise
    */
    public function isLoggedIn();
    
    /**
    * Logs a user out
    * @throws \MyHonors\Auth\Exception\NotLoggedInException
    * @return boolean TRUE on success, FALSE on failure
    */
    public function logout();
    
    /**
    * Gets the token of the user that is logged in
    * @throws \MyHonors\Auth\Exception\NotLoggedInException
    * @return \MyHonors\Auth\Contract\AuthTokenInterface
    */
    public function getToken();
    
}