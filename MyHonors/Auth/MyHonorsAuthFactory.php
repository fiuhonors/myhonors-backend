<?php

namespace MyHonors\Auth;

use \MyHonors\Auth\Contract\AuthFactoryInterface;
use \MyHonors\Auth\Contract\AuthSpecificInterface;
use \MyHonors\Auth\Contract\AuthTokenInterface;
use \MyHonors\Auth\Exception\NotLoggedInException;

class MyHonorsAuthFactory implements AuthFactoryInterface 
{

    private $authToken;
    
    private $loggedIn;
    
    public function __construct(AuthTokenInterface $authToken) 
    {
        $this->authToken = $authToken;
        
        $this->loggedIn = false;
    }
    
    public function loginByCredentials($username, $password, 
                                       AuthSpecificInterface $userLogin) 
    {

        if (!$userLogin->login($username, $password)) {
            return false;
        }
        
        $this->authToken->initialize($userLogin->getUser());
        
        return true;
    }
    
    public function loginByToken($sessionToken) 
    {
        $this->authToken->initializeManually($sessionToken);
        
        if (!$this->authToken->isValid()) {
            return false;
        }
        
        return true;
    }
    
    public function logout() 
    {
        if (!$this->loggedIn) {
            throw new NotLoggedInException();
        }
        
        return true;
    }

    public function getToken() 
    {
        if (!$this->loggedIn) {
            throw new NotLoggedInException();
        }
        
        return $this->authToken;
    }

}