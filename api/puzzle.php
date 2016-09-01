<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 8/26/2016
 * Time: 10:21 PM
 */

require_once realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php/StdHeader.php';
require_once 'Account.php';
require_once 'puzzles/Sudoku.php';

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

$action = RestfulGet("action");
$puzzle = RestfulGet("puzzle");
$user = RestfulGet("user");
$pass = RestfulGet("pass");
$token = RestfulGet("token");
$level = RestfulGet("level");

switch($action){
    case "get":
    {
        RestRequire(["puzzle", "user"]);

        if(isset($token)){
            getPuzzleData($puzzle, $level, $token);
        }else{
            getPuzzleData($puzzle, $level, $user, $pass);
        }
        break;
    }
    default:
    {
        throw new InvalidArgumentException("An action must be supplied.");
    }
}