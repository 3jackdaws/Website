<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 12:06 PM
 */

include_once realpath($_SERVER['DOCUMENT_ROOT']) . "/assets/php/StdHeader.php";

require_once 'Account.php';

$action = RestfulGet("action");
$user = RestfulGet("user");
$password = RestfulGet("pass");
$token = RestfulGet("token");
$email = RestfulGet("email");

$SECURITY_AGENT->AddLogInfo("Action: " . $action. "User: " . $user . " " . "Token: " . $token);

switch($action){
    case "register":
    {
        RestRequire(["user", "email", "pass"]);
        $account = new Account($user, $password, $email);
        echo "User registered";
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
        echo json_encode(["token" => $account->getNewToken()]);
        break;
    }
    default:
    {
        throw new InvalidArgumentException("You must specify an action");
    }

}
