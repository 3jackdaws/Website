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

$action = get("action");
$user = get("user");
$password = get("password");
$token = get("token");
$email = get("email");



switch($action){
    case "register":
    {
        foreach (["user", "email", "password"] as $varname){
            if($$varname == null) die("In order to register an account, you must provide the " . $varname . " parameter.");
        }
        $user = new Account($user, $password);
        $user->createNew($user, $email, $password);
        break;
    }
    case "gettoken":
    {
        $user = new Account($user, $password);
        echo json_encode(["token" => $user->getToken()]);
    }

}