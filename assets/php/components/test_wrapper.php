<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 9/5/2016
 * Time: 7:32 PM
 */
require_once realpath($_SERVER['DOCUMENT_ROOT']) . "/assets/php/StdHeader.php";

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);
function assert_handler($file, $line, $code, $desc = null)
{
    echo "<span class='test-fail'>Assertion failed at " . basename($file) . ":$line</span><br>";
    if ($desc) {
        echo "\"$desc\"";
    }
    echo "<br>";
    trigger_error("Test Failed",E_USER_ERROR);
};
assert_options(ASSERT_CALLBACK, 'assert_handler');

if(isset($_GET['test'])){
    ob_start();
    try{
        include(realpath($_SERVER['DOCUMENT_ROOT']) . "/assets/php/tests/". $_GET["test"]);
    }catch(Throwable $e){
        echo $e->getMessage() . "<br>";
        echo ob_get_clean();
        trigger_error("Test Threw Error", E_USER_ERROR);
    }
    echo ob_get_clean();
}else{
    echo "Test file name was not provided<br>";
}
