<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 12:06 PM
 */

function get($var){
    return isset($_GET[$var]) ? $_GET[$var] : $_POST[$var];
}

set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Account.php';
require_once "SecurityAgent.php";

$action = get("action");
$user = get("user");
$password = get("password");
$token = get("token");
$email = get("email");

$agent = new SecurityAgent();
$agent->LogAction("ACCOUNT:" . $action);

switch($action){
    case "register":
    {
        foreach (["user", "email", "password"] as $varname){
            if($$varname == null) die("In order to register an account, you must provide the " . $varname . " parameter.");
        }
        $account = new Account($user, $password);
        $account->createNew($user, $email, $password);
        break;
    }
    case "gettoken":
    {
        if($token != null){
            $account = new Account($token);
        }
        else{
            $account = new Account($user, $password);
        }
        echo json_encode(["token" => $account->getToken()]);
        break;
    }
    case "gentoken":
    {
        if($token != null){
            $account = new Account($token);
        }
        else{
            $account = new Account($user, $password);
        }
        $account->getNewToken();
        break;
    }
    default:
    {
        die("You must specify an action");
    }

}