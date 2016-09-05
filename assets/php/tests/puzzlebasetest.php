<?php
/**
 * Created by PhpStorm.
 * User: Tommy Miller
 * Date: 8/19/2016
 * Time: 9:39 PM
 */

require_once '../Puzzle.php';

class PuzzleTest extends Puzzle
{
    public function verifySolution(Account $user, $pass, $solution)
    {
        return true;
    }

}



$testPuzzle = new PuzzleTest("TestPuzzle");

$user = new Account("testuser", "testpassword");

$user->createNew("testuser", "tommy@tommydrum.net", "testpassword");

if ($testPuzzle->getPuzzleData($user, null) == null)
    printf("Unable to get Puzzle Data");
if ($testPuzzle->getTopPlayers(5) == null)
    printf("Unable to get top players");

$user->removeFromDatabase();
//no idea how to use setUserPuzzleCache.. need advising.