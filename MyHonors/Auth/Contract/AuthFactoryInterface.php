<?php

namespace MyHonors\Auth\Contract;

interface AuthFactoryInterface 
{
    
    /**
    * Logs a user in by use of credentials
    * @param string $username Username of user to log in
    * @param string $password Password of user to log in
    * @param \MyHonors\Auth\Contract\AuthSpecificInterface $specificLogin
    * @return boolean TRUE on success, FALSE on failure
    */
    public function loginByCredentials($username, $password, 
                                       AuthSpecificInterface $userLogin);
    
    /**
    * Logs a user in by use of a token
    * @param \MyHonors\Auth\Contract\AuthTokenInterface $sessionToken
    * @return boolean TRUE on success, FALSE on failure
    */
    public function loginByToken(AuthTokenInterface $sessionToken);
    
    /**
    * Logs a user out
    * @throws \MyHonors\Auth\Exception\NotLoggedInException
    * @return boolean TRUE on success, FALSE on failure
    */
    public function logout();
    
    /**
    * Gets the token of the user that is logged in
    * @throws \MyHonors\Auth\Exception\NotLoggedInException
    * @returns \MyHonors\Auth\Contract\AuthTokenInterface
    */
    public function getToken();
    
}