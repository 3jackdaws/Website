<?php

/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 11:44 AM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';
class Account
{
    protected $user;

    public function __construct($token_or_user, $password = null)
    {
        if ($password) {
            $sql = "SELECT * FROM users WHERE username=:user;";
            $statement = Database::connect()->prepare($sql);
            $statement->bindParam(':user', $token_or_user);
            $statement->execute();
            $this->user = $statement->fetch();
            if(!password_verify($password, $this->user['passwd'])){
                die("Unknown user and password combination.");
            }
        }else{
            $sql = "SELECT * FROM users WHERE token=:token;";
            $statement = Database::connect()->prepare($sql);
            $statement->bindParam(':token', $token_or_user);
            $statement->execute();
            $this->user = $statement->fetch();
        }
    }

    public function getNewToken(){
        
    }

    protected function generateToken(){
        return md5(microtime()) ^ md5($this->user['username']);
    }

    public function getUsername(){
        return $this->user['username'];
    }

    public function getEmail(){
        return $this->user['email'];
    }

    public function getToken(){
        return $this->user['token'];
    }

    public function getPasswordHash(){
        return $this->user['email'];
    }

    public function createNew($user, $email, $password){
        if(!$this->user['username']){
            $sql = "INSERT INTO users (username, email, token, password) VALUES(:user, :email, :token, :passhash);";
            $statement = Database::connect()->prepare($sql);
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $token = $this->generateToken();
            $statement->bindParam(':user', $user);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':token', $token);
            $statement->bindParam(':passhash', $hash);
            if(!$statement->execute()){
                echo "Error inserting user: " . $statement->errorInfo() . "<br>";
            }else{
                echo "User successfully registered.";
            }
        }else{
            die("User already exists.");
        }

    }


}