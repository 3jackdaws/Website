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
        echo "<span class='php-error-heading'>[" . get_class($exception) . "]</span><span class='php-error-body'>" . $exception->getMessage() . "</span>";
    }
    exit();
});

require_once('Database.php');
require_once('SecurityAgent.php');
require_once('JSONResponse.php');
require_once('PersistentDatastore.php');



const PUZZLE_TABLES = [ "sudoku",
                        "test"
                                    ];

function RestfulGet($varname){
    if(isset($_GET[$varname])) return $_GET[$varname];
    if(isset($_POST[$varname])) return $_POST[$varname];
    return null;
}

function RestRequire(array $vars){
    foreach ($vars as $param){
        if(!isset($param) OR $param === null){
            throw new HttpInvalidParamException("Required parameter \"" . $param . "\" was not set.");
        }
    }
}


$SECURITY_AGENT = new SecurityAgent();


