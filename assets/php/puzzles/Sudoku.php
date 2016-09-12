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
    static $generator_path = "assets/gen/SudokuGen.jar";
    static $command = "java -jar";
    public function __construct()
    {
    }

}