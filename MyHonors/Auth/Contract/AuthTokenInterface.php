<?php

namespace MyHonors\Auth\Contract;

interface AuthTokenInterface 
{
    
    /**
    * Initialize the token using provided user details
    * @param \MyHonors\Auth\Contract\UserInterface $userDetails
    */
    public function initialize(UserInterface $userDetails);
    
    /**
    * Initialize the token manually
    * @param mixed $authToken
    */
    public function initializeManually($authToken);
    
    /**
    * Gets the internal token
    * @throws \MyHonors\Auth\Exception\UninitializedTokenException
    * @return mixed
    */
    public function get();
    
    /**
    * Extends expiration of the token
    * @throws \MyHonors\Auth\Exception\UninitializedTokenException
    * @throws \MyHonors\Auth\Exception\InvalidTokenException
    * @param int $extendDuration Duration (in seconds) that the 
    *   token's expiration should be extended by.
    * @return mixed Token with an extended expiration
    */
    public function extend($extendDuration);
    
    /**
    * Decodes the token
    * @throws \MyHonors\Auth\Exception\UninitializedTokenException
    * @throws \MyHonors\Auth\Exception\InvalidTokenException
    * @returns array Contents of token
    */
    public function decode();
    
    /**
    * Checks if a token is valid
    * @throws \MyHonors\Auth\Exception\UninitializedTokenException
    * @returns boolean TRUE if token is valid, FALSE if not
    */
    public function isValid();
    
}