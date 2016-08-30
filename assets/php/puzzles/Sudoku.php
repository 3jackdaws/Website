<?php

/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 11:14 AM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Puzzle.php';

class Sudoku extends Puzzle
{
    private $level;
    private $username;
    private $puzzledata;
    public function __construct()
    {
        parent::__construct("sudoku");
    }

    public function verifySolution(Account $user, $level, $solution)
    {
        $this->getUserPuzzle($user);
        
        // checkRows();
        //checkCols();
        return false;
    }
    
    private function checkRows(){
        
    }
    
    private function getUserPuzzle($user){
        $sql = "SELECT level, datacache FROM :puzzle_type WHERE username=:user;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":puzzle_type", static::$type);
        $stmt->bindParam(":user", $user);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->level = $result['level'];
        $this->puzzledata = $result['datacache'];
    }
}