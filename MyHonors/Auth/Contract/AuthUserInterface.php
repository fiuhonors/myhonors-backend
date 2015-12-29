<?php

namespace MyHonors\Auth\Contract;

/**
* Represents an authenticated user
*/
interface AuthUserInterface 
{
    
    /**
    * Returns the username of the user
    * @return string User's username
    */
    public function getUserName();
    
    /**
    * Sets the username of the user
    * @param string $username User's username
    * @return void
    */
    public function setUserName($username);
    
    /**
    * Returns the email of the user
    * @return string User's email
    */
    public function getEmail();
    
    /**
    * Sets the email of the user
    * @param string $email User's email
    * @return void
    */
    public function setEmail($email);

    /**
    * Returns the full name of the user
    * @return string User's full name
    */
    public function getFullName();
    
    /**
    * Sets the full name of the user
    * @param string $fullName User's full name
    * @return void
    */
    public function setFullName($fullName);

    /**
    * Returns the group of the user
    * @return string User group
    */
    public function getGroup();
    
    /**
    * Sets the group of the user
    * @param string $group User's group
    * @return void
    */
    public function setGroup($userGroup);

    /**
    * Returns the permissions of the user
    * @return string[] User permissions
    */
    public function getPermissions();
    
    /**
    * Sets the permissions of the user
    * @param string[] $permissionsList User's set of permissions
    * @return void
    */
    public function setPermissions($permissionsList);
    
}