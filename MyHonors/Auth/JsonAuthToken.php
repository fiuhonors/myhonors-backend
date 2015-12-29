<?php

namespace MyHonors\Auth;

use \Firebase\JWT\JWT;
use \Exception;
use \MyHonors\Auth\Contract\AuthTokenInterface;
use \MyHonors\Auth\Contract\UserInterface;
use \MyHonors\Auth\Exception\UninitializedTokenException;
use \MyHonors\Auth\Exception\InvalidTokenException;

class JsonAuthToken implements AuthTokenInterface 
{
    
    
    /**
    * @var array Configuration settings for the auth token
    */
    private $config;
    /**
    * @var string The actual auth token to be passed between server 
    *   and client
    */
    private $token;
    /**
    * @var boolean Has the auth token been initialized?
    */
    private $initialized;
    
    
    private function __construct() {}

    public static function fromUserInformation(
        JWT $jwt, 
        array $config, 
        UserInterface $userDetails
    ) {
        $instance = new self();
        
        $currentTime = time();

        $payload = array(
            "iat" => $currentTime, 
            "exp" => $currentTime + $this->config['JWT_DURATION'],
            "username" => $userDetails->getUsername(),
            "email" => $userDetails->getEmail(),
            "fullname" => $userDetails->getFullname(),
            "group" => $userDetails->getGroup(),
            "permissions" => $userDetails->getPermissions()
        );

        $instance->config = $config;
        $instance->token = 
            JWT::encode($payload, $instance->config['JWT_KEY']);
        $instance->initialized = true;
        
        return $this;
    }
    
    public static function fromStringToken(
        JWT $jwt, 
        array $config, 
        $authToken
    ) {
        $instance = new self();
        
        $instance->config = $config;
        $instance->token = $authToken;
        $instance->initialized = true;
        
        return $instance;
    }
    
    public function get()
    {
        if ($this->initialized === false) {
            throw new UninitializedTokenException();
        }

        return $this->token;
    }
    
    public function extend($extendDuration)
    {
        if ($this->initialized === false) {
            throw new UninitializedTokenException();
        }

        $payload = $this->decodeToken();
        $payload["exp"] = time() + extendDuration;
        $this->token = JWT::encode($payload, $this->config['JWT_KEY']);

        return $this->token;
    }
    
    public function decode()
    {
        if ($this->initialized === false) {
            throw new UninitializedTokenException();
        }

        try {
            $payload = JWT::decode($this->token, 
                                   $this->config['JWT_KEY'], 
                                   array('HS256'));
        } catch (Exception $jwtException) {
            throw new InvalidTokenException();
        }

        return (array) $payload;
    }
    
    public function isValid()
    {
        if ($this->initialized === false) {
            throw new UninitializedTokenException();
        }

        try {
            JWT::decode($this->token, 
                        $this->config['JWT_KEY'], 
                        array('HS256'));
        } catch (Exception $jwtException) {
            return false;   
        }

        return true;
    }
    
    
}