<?php

/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 11:44 AM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';
require_once 'exception/AuthenticationException.php';
class Account
{
    protected $user;

    public function __construct($token_or_user, $password = null, $email = null)
    {
        if($email){
            $this->createNew($token_or_user, $email, $password);
        }
        if ($password) {
            $sql = "SELECT * FROM users WHERE LOWER(username)=LOWER(:username);";
            $statement = Database::connect()->prepare($sql);
            $statement->bindParam(':username', $token_or_user);
            $statement->execute();
            $this->user = $statement->fetch(PDO::FETCH_ASSOC);

            if(!password_verify($password, $this->user['passwd'])){
                throw new Exception("Invalid user or password.");
            }
        }else{
            $sql = "SELECT * FROM users WHERE token=:token;";
            $statement = Database::connect()->prepare($sql);
            $statement->bindParam(':token', $token_or_user);
            $statement->execute();
            $this->user = $statement->fetch(PDO::FETCH_ASSOC);

            if(strlen($this->user['username']) < 1) throw new Exception("Invalid token");
        }
    }

    public function getNewToken(){
        $this->user['token'] = $this->generateToken();
        $sql = "UPDATE users SET token=:token WHERE username=:user;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":token", $this->user['token']);
        $stmt->bindParam(":user", $this->user['username']);
        if(!$stmt->execute()){
//            var_dump($stmt->errorInfo());
            return false;
        }else{
            return $this->getToken();
        }
    }

    protected function generateToken(){
        $build = password_hash(microtime(), 1);
        return sprintf("%s-%s-%s", substr($build, 10,5),substr($build, 20,5),substr($build, 30,5));
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
        return $this->user['passwd'];
    }

    public function removeFromDatabase(){
        sleep(1);
        if($this->user['username']){
            $sql = "DELETE FROM users WHERE username=:username;";
            $statement = Database::connect()->prepare($sql);
            $statement->bindParam(':username', $this->user['username']);
            if(!$statement->execute()){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    public function createNew($user, $email, $password){
//        sleep(1);
        //make sure user isn't already in database

        $sql = "SELECT username FROM users WHERE LOWER(username) = LOWER(:username);";
        $statement = Database::connect()->prepare($sql);
        $statement->bindParam(":username", $user);
        $statement->execute();
        if($statement->fetch() !== false)
            throw new Exception("User already exists");

        $sql = "INSERT INTO users (username, email, token, passwd) VALUES(:user, :email, :token, :passhash);";
        $statement = Database::connect()->prepare($sql);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $this->user['username'] = $user;
        $this->user['token'] = $this->generateToken();
        $statement->bindParam(':user', $user);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':token', $this->user['token']);
        $statement->bindParam(':passhash', $hash);
//        echo $hash;
        if(!$statement->execute()){
            throw new Exception("User already exists");
        }else{
            return true;
        }


    }


}