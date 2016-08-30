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
    private $user;
    private $puzzleN;
    private $puzzledata;
    static $type = "sudoku";
    static $generator_path = "assets/gen/SudokuGenerator.jar";
    static $command = "java -jar";
    public function __construct()
    {
    }

    public function verifySolution(Account $user, $level, $solution)
    {
        $this->getUserPuzzle($user->getUsername());
        if($level == $this->level){
            $puzzle = [];
            $n = $this->puzzleN;
            $this->puzzledata = explode(" ",$this->puzzledata);
            $this->dumpPuzzleData();
//            for ($i = 0;$i<$n*$n; $i++){
//
//            }
        }
        return false;
    }

    public function dumpPuzzleData(){
        $n = $this->puzzleN;
        for ($i = 0; $i<$n*$n; $i++){
            echo $this->puzzledata[$i] . " ";
        }
        echo "<br>";
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