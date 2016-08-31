<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 8/26/2016
 * Time: 10:21 PM
 */

require_once realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php/StdHeader.php';
require_once 'Database.php';
require_once 'Account.php';
require_once 'puzzles/Sudoku.php';

function get($var){
    return isset($_GET[$var]) ? $_GET[$var] : $_POST[$var];
}


function getPuzzleData($puzzle, $level, $user_or_token, $password = null){
    if($password){
        $account = new Account($user_or_token, $password);
    }else{
        $account = new Account($user_or_token);
    }
    switch ($puzzle){
        case "sudoku":
        {
            $generator = new Sudoku();
            echo $generator->getPuzzleData($account)['datacache'];
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
        if(!isset($puzzle) or !isset($user)) throw new InvalidArgumentException("puzzle and user are required parameters");;

        if($puzzle == "current"){

        }else{
            if(isset($token)){
                getPuzzleData($puzzle, $level, $token);
            }else{
                getPuzzleData($puzzle, $level, $user, $pass);
            }

        }
        break;
    }
    default:
    {
        throw new InvalidArgumentException("An action must be supplied.");
    }
}