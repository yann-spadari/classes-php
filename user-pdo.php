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

    public function connect($login, $password) {

        $db = new PDO('localhost','root','','classes');
        $req = $db->prepare("SELECT * FROM utilisateurs");
        $req->execute();
        $user = $req->fetchAll(PDO::FETCH_ASSOC);

        if($password == $user['password'] && $login == $user['login']) {

            session_start();
            $_SESSION['login'] = $user['login'];
			$_SESSION['id'] = $user['id'];
			header("Location: index.php");

			exit;
        } 
        
        else {

            echo "Mot de passe incorrect.";

        }
    }

    public function disconnect() {

        session_destroy();
        header('Location:connexion.php');

    }

    public function delete($login) {
        
        $db = new PDO('localhost','root','','classes');
        $req = $db->prepare("DELETE FROM utilisateurs WHERE login = $login");
        $req->execute();
        session_destroy();
        header('Location:connexion.php');

    }

    public function update($login, $password, $email, $firstName, $lastName) {
        
        $db = new PDO('localhost','root','','classes');
        $req = $db->prepare("UPDATE utilisateurs SET login = '$login', password = '$password', email = '$email', firstname = '$firstname', lastname = '$lastname' WHERE id = $this->id");
        $req->execute();
    }

    public function isConnected() { 
        
        if (isset($_SESSION['login'])) {
            
            return true;

        } 
        
        else {
            
            return false;
        }
    }

    public function getAllInfos() {
        
        $db = new PDO('localhost','root','','classes');
        $req = $db->prepare("SELECT * FROM `utilisateurs` WHERE login = '".$_SESSION['login']."'");
        $req->execute();
        $result = $req->fetchall(PDO::FETCH_ASSOC);
        return $result;

    }

    public function getEmail() {
        
        $db = new PDO('localhost','root','','classes');
        $req = $db->prepare("SELECT email FROM utilisateurs WHERE login = '$this->login'");
        $req->execute();
        $result = $req->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getFirstname() {
        
        $db = new PDO('localhost','root','','classes');
        $req = $db->prepare("SELECT firstname FROM utilisateurs WHERE login = '$this->login'");
        $req->execute();
        $result = $req->fetchall(PDO::FETCH_ASSOC);
        return $result;

    }

    public function getLastname() {
        
        $db = new PDO('localhost','root','','classes');
        $req = $db->prepare("SELECT lastname FROM utilisateurs WHERE login = '$this->login'");
        $req->execute();
        $result = $req->fetchall(PDO::FETCH_ASSOC);
        return $result;
        
    }
}