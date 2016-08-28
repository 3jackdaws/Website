<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 8/26/2016
 * Time: 10:21 PM
 */

set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';
require_once 'Account.php';

function get($var){
    return isset($_GET[$var]) ? $_GET[$var] : $_POST[$var];
}

function requiredParameters(array $params){
    foreach ($params as $p){
        if(!isset($$p)){
            echo $p . " is a required parameter";
            return false;
        }
    }
    return true;
}

function getPuzzleData($puzzle, $level, $user_or_token, $password = null){
    if($password){
        $account = new Account($user_or_token, $password);
    }
    switch ($puzzle){
        case "":
        {
            break;
        }
    }
}

$action = get("action");
$puzzle = get("puzzle");
$user = get("user");
$pass = get("pass");
$token = get("token");
$level = get("level");

switch($action){
    case "get":
    {
        if(!requiredParameters(["puzzle", "user"])) return;

        if($puzzle == "current"){

        }else{
            if(isset($token)){
                getPuzzleData($puzzle, $level, $token);
            }else{
                getPuzzleData($puzzle, $level, $token);
            }

        }
    }
}