<?php

//testname: User GET POST
//testdesc: Simulates an actual user running multiple POST and GET requests in order to make sure the public facing API works as intended.

/**
 * Created by PhpStorm.
 * User: Tommy Miller
 * Date: 9/3/2016
 * Time: 5:24 PM
 */

require_once realpath($_SERVER['DOCUMENT_ROOT']) . "/assets/php/StdHeader.php";
require_once "Account.php";

$user = "testuser";
$password = "testpassword";
$email = "tommy@tommydrum.net";

//create new account via public api


$returns = file_get_contents("http://localhost/api/account.php?action=register&user=$user&pass=$password&email=$email");
assert(strpos($returns, "User registered") !== false, "Assert that 'User registered' found in page source.");

$returns = file_get_contents("http://localhost/api/account.php?action=register&user=$user&pass=tespass&email=$email");
assert(strpos($returns, "User already exists") !== false, "Assert that registering a user with the same username isnt allowed");

$returns = file_get_contents("http://localhost/api/account.php?action=gettoken&user=$user&pass=$password");

$account = new Account($user, $password);
assert(json_decode($returns)->token == $account->getToken(),"Assert that gettoken api call returns correct token");

$token = json_decode($returns)->token;
$returns = file_get_contents("http://localhost/api/account.php?action=gentoken&token=$token");
$token = json_decode($returns)->token;
$account=new Account($token);
$token = $account->getToken();
echo $token;
assert(json_decode($returns)->token == $token, "Assert that genToken api call works.");

cleanup();

function cleanup(){
    try{
        $account = new Account("testuser", "testpassword");
        $account->removeFromDatabase();
    }catch (Exception $e){
        echo $e->getMessage();
    }
}


