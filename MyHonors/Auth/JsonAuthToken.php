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

    private $config;

    private $token;
    private $initialized;

    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->initialized = false;
    }

    public function initialize(UserInterface $userDetails) 
    {
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

        $this->token = JWT::encode($payload, $this->config['JWT_KEY']);
        $this->initialized = true;
    }

    public function initializeManually($authToken)
    {
        $this->token = $authToken;
        $this->initialized = true;
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