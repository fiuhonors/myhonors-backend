<?php

namespace MyHonors\Auth;

use \MyHonors\Auth\Contract\AuthFactoryInterface;
use \MyHonors\Auth\Contract\AuthDriverInterface;
use \MyHonors\Auth\Contract\AuthTokenInterface;
use \MyHonors\Auth\Exception\NotLoggedInException;

class MyHonorsAuthFactory implements AuthFactoryInterface 
{
    
    /**
    * @var \MyHonors\Auth\Contract\AuthDriverInterface;
    */
    private $authDriver;
    /**
    * @var \MyHonors\Auth\Contract\AuthTokenInterface
    */
    private $authToken;
    /**
    * @var boolean
    */
    private $isLoggedIn;
    
    
    public function __construct(
        AuthDriverInterface $authDriver, 
        AuthTokenInterface $authToken)
    {
        $this->authDriver = $authDriver;
        $this->authToken = $authToken;
        $this->isLoggedIn = false;
    }
    
    public function loginByCredentials($username, $password) 
    {   
        if (!$this->authDriver->login($username, $password)) {
            return false;
        }
        
        $this->isLoggedIn = true;
        $this->authToken->fromUserInformation(
            $this->authDriver->getUser()
        );
        
        return true;
    }
    
    public function loginByToken($authToken) 
    {
        $this->authToken->fromAuthToken($authToken);
        
        if (!$this->authToken->isValid()) {
            $this->authToken->clear();
            return false;
        }
        
        $this->isLoggedIn = true;
        return true;
    }
    
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }
    
    public function logout() 
    {
        if (!$this->isLoggedIn) {
            throw new NotLoggedInException();
        }
        
        $this->authDriver->logout();
        $this->authToken->clear();
        $this->isLoggedIn = false;
        return true;
    }
    
    public function getToken() 
    {
        if (!$this->isLoggedIn) {
            throw new NotLoggedInException();
        }
        
        return $this->authToken;
    }

    
}