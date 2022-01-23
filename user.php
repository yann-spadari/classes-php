<?php

class User {

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

    public function register($login, $password, $email, $firstName, $lastName) {

        $db = mysqli_connect('localhost','root','','classes');
        $req = mysqli_prepare($db, "INSERT INTO utilisateurs(login, password, email, firstname, lastname)
        VALUES('$login', '$password', '$email', '$firstName', '$lastName')");
        mysqli_stmt_execute($req);

    }

    public function connect($login, $password) {

        $db = mysqli_connect('localhost','root','','classes');
	    $req = "SELECT * FROM `utilisateurs` WHERE login ='$login'";
	    $result = mysqli_query($db, $req);
        $user = mysqli_fetch_assoc($result);

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
        header('Location: connexion.php');
        
    }

    public function delete($login) {

        $db = mysqli_connect('localhost','root','','classes');
        $req = "DELETE FROM utilisateurs WHERE login = $login";
        $result = mysqli_query($db,$req);
        session_destroy();
        header('Location: connexion.php');

    }

    public function update($login, $password, $email, $firstName, $lastName) {

        $db = mysqli_connect('localhost','root','','classes');
        $req = "UPDATE utilisateurs SET login = '$login', password = '$password', email = '$email', firstname = '$firstName', lastname = '$lastName' WHERE id = $this->id";
        $update = mysqli_query($db, $req);

        if(isset($update)) {
            
            echo "Vos données ont été mises à jour.";

        }
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

        $db = mysqli_connect('localhost','root','','classes');
        $req = "SELECT * FROM utilisateurs WHERE login='".$_SESSION['login']."'";
        $result = mysqli_query($db,$req);
        $userSession = mysqli_fetch_all($result,MYSQLI_ASSOC);
        return $userSession;

    }

    public function getLogin() {

        $db = mysqli_connect('localhost','root','','classes');
        $req = "SELECT login FROM utilisateurs where login = '$login'";
        $result = mysqli_query($db, $req);
        $getLogin = mysqli_fetch_assoc($result);
        return $getLogin;
        
    }

    public function getEmail() {

        $db = mysqli_connect('localhost','root','','classes');
        $req = "SELECT email FROM utilisateurs where login = '$login'";
        $result = mysqli_query($db, $req);
        $getLogin = mysqli_fetch_assoc($result);
        return $getEmail;

    }
    
    public function getFirstname() {

        $db = mysqli_connect('localhost','root','','classes');
        $req = "SELECT firstname FROM utilisateurs where login = '$login'";
        $result = mysqli_query($db, $req);
        $getLogin = mysqli_fetch_assoc($result);
        return $getFirstname;

    }

    public function getLastname() {

        $db = mysqli_connect('localhost','root','','classes');
        $req = "SELECT lastname FROM utilisateurs where login = '$login'";
        $result = mysqli_query($db, $req);
        $getLogin = mysqli_fetch_assoc($result);
        return $getLastname;

    }

}