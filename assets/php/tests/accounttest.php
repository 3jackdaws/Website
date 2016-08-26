<?php
/**
 * Created by PhpStorm.
 * User: Tommy Miller
 * Date: 8/19/2016
 * Time: 9:39 PM
 */

require_once 'Account.php';
require_once "SecurityAgent.php";

$action = get("action");
//$user = get("user");
//$password = get("password");
//$token = get("token");
//$email = get("email");
$user = "testuser";
$password = "testpassword";
$email = "tommy@tommydrum.net";

$agent = new SecurityAgent();
$agent->LogAction("ACCOUNT:" . $action);

$account = new Account($user, $password);
if($account == null)
    printf("Register failed.");
else
{
    $account->createNew($user, $email, $password);
    printf("Registered account, new token is %s", $account->getNewToken());
    printf("Username is %s", $account->getUsername());
    printf("Email is %s", $account->getEmail());
    printf("GetToken returns %s", $account->getToken());
    printf("Password Hash is %s", $account->getPasswordHash());
}

//Note to Ian, On line 92 of Account.php, would you please delete the user then re-create it?
//That would be great for testing. Thx.