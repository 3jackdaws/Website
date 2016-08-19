<?php

/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 9:52 AM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';

abstract class Puzzle
{
    protected $type;
    protected static $generator_path = "";
    public function __construct($puzzle_type)
    {
        if($puzzle_type == null) die("Puzzle constructor requires a puzzle type for its first argument");
        $this->type = $puzzle_type;
    }

    public function getPuzzleData($user, $level){
        $cache = $this->getCachedLevelData($user);
        if($level == null) $level = $cache['maxlevel'];
        if($cache['level'] != $level){
            exec(self::$generator_path . " " . $user . " " . $level);
            $cache = $this->getCachedLevelData($user);
        }
        return $cache;
    }

    protected function getCachedLevelData($user){
        $sql = "SELECT * FROM " . $this->type . " WHERE user=:user LIMIT 1;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":user", $user);
        $stmt->execute();
        return $stmt->fetch();
    }

    public abstract function verifySolution($user, $pass, $solution);
}