<?php
/**
 * Created by PhpStorm.
 * User: Cryotech
 * Date: 8/28/2016
 * Time: 12:44 AM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . "/assets/php/tests");
require_once 'Test_Puzzle.php';

echo '<p>Testing...</p>';

$gen = new Test_Puzzle();
$gen->createNewPuzzleTable();
$gen->createPuzzleUser("amadeus", 0, 10, null); // Generate sample user

$data = $gen->getPuzzleData("amadeus", 0);

var_dump($gen->getPuzzleData("invaliduser")); // should return false
var_dump($gen->getPuzzleData("amadeus", 99));

echo '<br />';

echo strstr($data['datacache'], PHP_EOL); // Newlines preserved? // Yes.

echo '<br />';

$gen->createPuzzleUser("highscore", 0, 1000, null); // Test top players
var_dump($top = $gen->getTopPlayers(10));

echo '<br />';

echo $top[0]['username'];
//echo $top[0][0];

echo '<br />';

foreach ($top as $score)
    echo $score['username'] . ' - ' . $score['maxlevel'] . '<br />';

echo '<br />';

var_dump($gen->verifySolution('amadeus', 0, null));

echo '<br />';

echo '<p>Done. (verify ' .  microtime() . ')</p>';