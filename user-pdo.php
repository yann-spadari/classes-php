<?php

class UserPDO {

    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;
 
    public function __construct($login ="", $email ="", $firstName ="", $lastName= "") {
        $this->login = $login;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    

}