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
    public function VerifySolution($user, $pass, $solution)
    {
        return true;
    }
}



$testPuzzle = new PuzzleTest("TestPuzzle");

$user = new Account("testuser", "testpassword");

if (getPuzzleData($user, null) == null)
    printf("Unable to get Puzzle Data");
if (getTopPlayers(5) == null)
    printf("Unable to get top players");

//no idea how to use setUserPuzzleCache.. need advising.