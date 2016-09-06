<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 9/6/16
 * Time: 7:53 AM
 */

$this_file = $argv[0];
$action = $argv[1];
$username = $argv[2];
$level = $argv[3];
if ($action == "verify")
    $solution = $argv[4];


if($action == "generate"){
    echo "Testing" . "\n";

    echo $argv[2] . " " . $argv[3] . "\n";
}
else if($action == "verify"){
    if($solution == "blue"){
        echo "true";
    }else{
        echo $solution;
    }
}

