<?php
//testname: NOINCLUDE
//testdesc:
/**
 * Created by PhpStorm.
 * User: Cryotech
 * Date: 8/28/2016
 * Time: 12:40 AM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . "/assets/php");
require_once 'Puzzle.php';

class TestPuzzle extends Puzzle
{
    protected static $type = "test";
    protected static $generator_path = "assets/gen/test_generator.php";
    protected static $command = "php";
}

