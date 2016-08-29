<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 7/10/2016
 * Time: 10:05 PM
 */
class Database
{
    private static $_connection;
    private static $database = "puzzles";
    private static function _instantiate(){
        self::$_connection = new PDO('mysql:host=localhost;dbname='. self::$database, "puzzles", '');
        date_default_timezone_set('America/Los_Angeles');
    }
    /**
     * @return PDO
     */
    public static function connect(){
        if(!self::$_connection instanceof PDO){
            self::_instantiate();
        }
        return self::$_connection;
    }
    public static function getGUID(){
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function setTestDatabase(){
        self::$database = "puzzles_test";
    }
}