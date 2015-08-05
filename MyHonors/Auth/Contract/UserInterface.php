<?php

namespace MyHonors\Auth;

interface UserInterface 
{
    
    /**
    * Returns the username of the user
    * @return string User username
    */
    public function getUsername();
    
    /**
    * Returns the email of the user
    * @return string User email
    */

    /**
    * Returns the fullname of the user
    * @return string User full name
    */
    public function getFullname();

    /**
    * Returns the group of the user (FIU Student, Staff, Alumni, 3rd Party)
    * @return string User group
    */
    public function getGroup();

    /**
    * Returns the permissions of the user
    * @return array User permissions
    */
    public function getPermissions();

    /**
    * Returns all the details of the user
    * @return array Associative array of user details
    */
    public function getDetails();
    
}