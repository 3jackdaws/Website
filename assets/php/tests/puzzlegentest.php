<?php
//testname: Puzzle Generator Test
//testdesc: Tests that the TestPuzzle class and generator file work correctly.  If they do, it is easy for new generators to be added.
/**
 * Created by PhpStorm.
 * User: Cryotech
 * Date: 8/28/2016
 * Time: 12:44 AM
 */
require_once realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php/StdHeader.php';
require_once 'TestPuzzle.php';

function cleanup(){
    try{
        $account = new Account("Amadeus", "NotAGoodPassword");
        $account->removeFromDatabase();
    }catch (Exception $e){

    }
    try{
        $account = new Account("highscore", "AlsoABadPassword");
        $account->removeFromDatabase();
    }catch (Exception $e){

    }
}

$account = new Account("Amadeus", "NotAGoodPassword", "email@email.ru");
$gen = new TestPuzzle();
$gen->createNewPuzzleTable();
$gen->createPuzzleUser($account, 0, 10, null); // Generate sample user
$data = $gen->getPuzzleData($account, 0);

assert(strpos($data['datacache'], "Amadeus") != false , "Assert that getPuzzleData() returns the correct data");
assert(strpos($data['datacache'], "0") != false , "Assert that getPuzzleData() returns the correct data");

$account = new Account("highscore", "AlsoABadPassword", "email@email.ca");

$gen->createPuzzleUser($account, 0, 1000, null); // Test top players
$gen->getPuzzleData($account);


$top = $gen->getTopPlayers(10);
assert($top[0]['username'] == "highscore", "Looking for 'highscore', got '" . $top[0]['username'] . "'");


assert($gen->verifySolution($account, "blue") === true, "Assert that 'blue' is correct solution"); // GenTest.exe will output true if solution is "blue"
assert($gen->verifySolution($account, "red") !== true, "Assert that 'red' is incorrect solution"); // GenTest.exe will output false if solution is anything else

cleanup();
