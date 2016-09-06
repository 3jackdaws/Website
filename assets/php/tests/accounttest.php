<?php
//testname: Account Class Test Functionality
//testdesc: Tests the various Account methods to make sure they always work.  
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


$account = new Account($user, $password, $email);

//Check that a newly created user account has the correct values
assert($user == $account->getUsername(), "Check if Account object holds correct username");
assert(strlen($account->getPasswordHash()) == 60, "Check if Account object has hashed password");
assert($email == $account->getEmail(), "Check if Account object holds correct email");
$token = $account->getToken();
assert(strlen($token) == 17, "Check if token is correct size");


//check that a user account can be instantiated with the token
$account = new Account($token);
assert($user == $account->getUsername(), "Check if Account object holds correct username");
assert(strlen($account->getPasswordHash()) == 60, "Check if Account object has hashed password");
assert($email == $account->getEmail(), "Check if Account object holds correct email");
$account->getNewToken();
$token = $account->getToken();
assert(strlen($token) == 17, "Check if token is correct size");

//check that the new token is up to date iun the database
$account = new Account($token);
assert($user == $account->getUsername(), "Check if Account object holds correct username");

$account = new Account($user, $password);
$account->removeFromDatabase();

