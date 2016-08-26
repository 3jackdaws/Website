<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/26/16
 * Time: 12:48 PM
 */

set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';
require_once 'GenericDatastore.php';
require_once 'Puzzle.php';

$puzzle = new 
