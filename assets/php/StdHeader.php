<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/29/16
 * Time: 10:46 AM
 *
 * Sets up the PHP environment correctly
 */

set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');

set_exception_handler(function (Throwable $exception){
    if(get_class($exception) == "Error"){
        error_log("PHP Error on line " . $exception->getLine() . " of " . $exception->getFile() . ". " . $exception->getMessage());
    }
    else{
        echo "<span class='php-error'>[" . get_class($exception) . "]<br>" . $exception->getMessage() . "</span>";
    }
    exit();
});
