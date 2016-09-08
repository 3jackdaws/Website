<?php
//testname: JSONResponse Test
//testdesc: Tests the JSONResponse class.  Neccessary because JSONResponse objects should be used for all user visible data-only repsonses
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/20/16
 * Time: 1:53 PM
 */


set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'JSONResponse.php';

$response = new JSONResponse();


$response->set('key1', 'value1');
$response->set('key2', 'value2');
$response->set('key3', 'value3');

ob_start();

echo $response;

$json = ob_get_clean();

assert($json == "{\"key1\":\"value1\",\"key2\":\"value2\",\"key3\":\"value3\"}", "assert correct echo behavior");



