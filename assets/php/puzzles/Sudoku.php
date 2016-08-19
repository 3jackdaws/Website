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
    public function __construct()
    {
        parent::__construct("sudoku");
    }

    public function verifySolution($user, $pass, $solution)
    {
        // checkRows();
        //checkCols();
        return false;
    }
}