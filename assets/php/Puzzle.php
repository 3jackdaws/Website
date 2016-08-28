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

    public function __construct($puzzle_type)
    {
        if($puzzle_type == null){
            echo("Puzzle constructor requires a puzzle type for its first argument");
            return null;
        }
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

    public function getTopPlayers($number){
        if(is_int($number)){
            $sql = "SELECT username, maxlevel FROM " . $this->type . " ORDER BY maxlevel DESC LIMIT " . $number;
            $stmt = Database::connect()->prepare($sql);
            $stmt->bindParam(":user", $user);
            $stmt->execute();
            return $stmt->fetch();
        }
        return false;
    }

    public function setUserPuzzleCache($puzzle, $user, $level, $data){
        $sql = "INSERT INTO :puzzle_table (username, datacache, level) VALUES(:user, :data, :level) ON DUPLICATE KEY UPDATE username=:user, datacache=:data, level=:level;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":puzzle_table", $puzzle);
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":level", $level);
        $stmt->bindParam(":data", $data);
        $stmt->execute();
    }

    public function createNewPuzzleTable(){
        $sql = "CREATE TABLE :puzzle_type(
                username VARCHAR (38) NOT NULL UNIQUE,
                datacache VARCHAR (32000),
                level INTEGER,
                maxlevel INTEGER ,
                PRIMARY KEY (username)
                );";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":puzzle_type", $this->type);
        return $stmt->execute();
    }
}