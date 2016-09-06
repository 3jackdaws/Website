<?php
/**
 * Created by PhpStorm.
 * User: Cryotech
 * Date: 8/28/2016
 * Time: 12:44 AM
 */
require_once realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php/StdHeader.php';
require_once 'TestPuzzle.php';

$account = new Account("Amadeus", "NotAGoodPassword", "email@email.ru");
$gen = new TestPuzzle();
$gen->createNewPuzzleTable();
$gen->createPuzzleUser($account, 0, 10, null); // Generate sample user
$data = $gen->getPuzzleData($account, 0);

echo $data['datacache'];
assert(strpos($data['datacache'], "Amadeus") != false , "Assert that getPuzzleData() returns the correct data");
assert(strpos($data['datacache'], "0") != false , "Assert that getPuzzleData() returns the correct data");

$account->removeFromDatabase();

$account = new Account("highscore", "AlsoABadPassword", "email@email.ca");

$gen->createPuzzleUser($account, 0, 1000, null); // Test top players
$gen->getPuzzleData($account);

var_dump($top = $gen->getTopPlayers(10));

echo '<br />';

echo $top[0]['username'];
//echo $top[0][0];

echo '<br />';

foreach ($top as $score)
    echo $score['username'] . ' - ' . $score['maxlevel'] . '<br />';

echo '<br />';

assert($gen->verifySolution($account, "blue") == true, "Assert that 'blue' is correct solution"); // GenTest.exe will output true if solution is "blue"
assert($gen->verifySolution($account, "red") == false, "Assert that 'red' is incorrect solution"); // GenTest.exe will output false if solution is anything else
$account->removeFromDatabase();
