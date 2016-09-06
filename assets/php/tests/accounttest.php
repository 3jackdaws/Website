<?php
/**
 * Created by PhpStorm.
 * User: Tommy Miller
 * Date: 8/19/2016
 * Time: 9:39 PM
 */
require_once realpath($_SERVER['DOCUMENT_ROOT']) . "/assets/php/StdHeader.php";
require_once "Account.php";
$user = "testuser";
$password = "testpassword";
$email = "tommy@tommydrum.net";


$account = new Account($user, $password);
if($account == null)
    echo "Register failed.";
else
{
    $account->createNew($user, $email, $password);
    echo "Registered account, new token is ". $account->getNewToken();
    echo "Username is ". $account->getUsername();
    echo "Email is ". $account->getEmail();
    echo "GetToken returns ". $account->getToken();
    echo "Password Hash is ". $account->getPasswordHash();
    echo "Removing account from database";
    $account->removeFromDatabase();
}
