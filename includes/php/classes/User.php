<?php

require_once 'DB.php';

class User
{
    private $user_id;
    private $user_name;
    private $user_email;
    private $user_password;
    private $user_type;

    public function __construct()
    {
        $this->user_id = 0;
        $this->user_name = '';
        $this->user_email = '';
        $this->user_password = '';
        $this->user_type = 'user';
    }

    //getters
    public function getUserId()
    {
        return $this->user_id;
    }
    public function getUsername()
    {
        return $this->user_name;
    }
    public function getUseremail()
    {
        return $this->user_email;
    }
    public function getUserpassword()
    {
        return $this->user_password;
    }
    public function getUsertype()
    {
        return $this->user_type;
    }

    //setters
    public function setUserId($id)
    {
        $this->user_id = $id;
    }
    public function setUsername($name)
    {
        $this->user_name = $name;
    }
    public function setUseremail($email)
    {
        $this->user_email = $email;
    }
    public function setUserPassword($password)
    {
        $this->user_password = $password;
    }
    public function setUsertype($type)
    {
        $this->user_type = $type;
    }
}
