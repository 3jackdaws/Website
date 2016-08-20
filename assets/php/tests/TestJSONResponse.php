<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/20/16
 * Time: 1:53 PM
 */

function println($str){
    echo $str . "<br>";
}

set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'JSONResponse.php';

$response = new JSONResponse();

println("Set several keys:");

$response->set('key1', 'value1');
$response->set('key2', 'value2');
$response->set('key3', 'value3');

println($response);

println("Add errors");

$response->error("Standard error");
echo "One error: " . $response . "<br>";
$response->error("Another error");
echo "Two errors: " . $response . "<br>";

println("Clear");
$response->clear();
println($response);

println("Create a arbitrary array");
$response->createArray("links");
$response->appendAll('links', ['1','2','3','4']);

println($response);

println("deset array");

$response->deset('links');

println($response);

$response->clear();
$response->appendAll('test', [1]);

println($response);

