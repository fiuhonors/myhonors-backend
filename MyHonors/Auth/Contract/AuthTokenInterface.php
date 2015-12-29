<?php

namespace MyHonors\Auth\Contract;

/**
* A string session token that can be transferred between server and 
*   client that can be used to identify a specific session user.
*/
interface AuthTokenInterface 
{
    
    /**
    * Initialize the token using provided user details
    * @param \MyHonors\Auth\Contract\AuthUserInterface $userDetails
    * @return void
    */
    public function fromUserInformation(
        AuthUserInterface $userDetails
    );
    
    /**
    * Initialize the token manually, provided an existing 
    *   stringified token.
    * @param string $authToken
    * @return void
    */
    public function fromStringToken($authToken);
    
    /**
    * Returns a string representation of this token. Calling an 
    *   AuthTokenInterface-compliant class' "fromStringToken" method 
    *   on this string should yield an equivalent authentication 
    *   token.
    * @throws \MyHonors\Auth\Exception\UninitializedTokenException
    * @return string
    */
    public function get();
    
    /**
    * Gets the information of the user stored in the token
    * @throws \MyHonors\Auth\Exception\UninitializedTokenException
    * @throws \MyHonors\Auth\Exception\InvalidTokenException
    * @return \MyHonors\Auth\Contract\AuthUserInterface
    */
    public function getUser();
    
    /**
    * Returns a string representation of this token with extended 
    *   expiration.
    * @throws \MyHonors\Auth\Exception\UninitializedTokenException
    * @throws \MyHonors\Auth\Exception\InvalidTokenException
    * @param int $extendDuration Duration (in seconds) that the 
    *   token's expiration should be extended by.
    * @return string String token with an extended expiration
    */
    public function extend($extendDuration);
    
    /**
    * Checks if a token is valid.
    * @throws \MyHonors\Auth\Exception\UninitializedTokenException
    * @return boolean TRUE if token is valid, FALSE if not
    */
    public function isValid();
    
    /**
    * Clears the current represented authentication token. This 
    *   should clear the object as if it wasn't even initialized 
    *   by either the fromUserInformation or fromStringToken 
    *   method to begin with.
    * @return void
    */
    public function clear();
    
}