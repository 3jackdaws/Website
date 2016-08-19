<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 11:13 AM
 */

set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Sudoku.php';
require_once 'UserVars.php';

$level = null;

foreach ($_POST as $key => $value) {
    $$key = $value;
}

$sudoku = new Sudoku();

if($solution){
    if($sudoku->verifySolution($user, $pass, $solution)){
        echo "That's correct.";
    }else{
        echo "Your solution sucked.";
    }
}



