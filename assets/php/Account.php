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
            if($this->user['username']){
                if(!password_verify($password, $this->user['passwd'])){
                    die("Unknown user and password combination.");
                }
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
        $this->user['token'] = $this->generateToken();
        $sql = "UPDATE users SET token=:token WHERE username=:user;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":token", $this->user['token']);
        $stmt->bindParam(":user", $this->user['username']);
        if(!$stmt->execute()){
            var_dump($stmt->errorInfo());
            return false;
        }else{
            echo $this->getToken();
            return true;
        }
    }

    protected function generateToken(){
        if(!$this->user['username']) return;
        $build = password_hash(microtime() ^ $this->user['username'], 1);
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

    public function createNew($user, $email, $password){
        sleep(1);
        if(!$this->user['username']){
            $sql = "INSERT INTO users (username, email, token, passwd) VALUES(:user, :email, :token, :passhash);";
            $statement = Database::connect()->prepare($sql);
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $this->user['token'] = $this->generateToken();
            $statement->bindParam(':user', $user);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':token', $this->user['token']);
            $statement->bindParam(':passhash', $hash);
            if(!$statement->execute()){
                echo "Error inserting user: ";
                var_dump($statement->errorInfo());
            }else{
                echo "User successfully registered.";
            }
        }else{
            echo("User already exists.");
        }

    }


}