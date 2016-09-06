<?php
/**
 * Created by PhpStorm.
 * User: Tommy Miller
 * Date: 9/3/2016
 * Time: 5:24 PM
 */

require_once realpath($_SERVER['DOCUMENT_ROOT']) . "/assets/php/StdHeader.php";
require_once "Account.php";
require_once '../puzzles/Sudoku.php';

$user = "testuser";
$password = "testpassword";
$email = "tommy@tommydrum.net";


echo "Creating test user" . "<br>";
$account = new Account($user, $password);
$account->createNew($user, $email, $password);
echo "Do puzzle tests" . "<br>";

printf("Sudoku test");
$puzzle = new Sudoku();
$puzzle->createPuzzleUser($user);
$level = $puzzle->dumpPuzzleData();
//currently verifySolution is not fully implemented. Expecting to return false.
$puzzle->verifySolution($account, $level, null);

printf("Deleting test user");
$account->removeFromDatabase();