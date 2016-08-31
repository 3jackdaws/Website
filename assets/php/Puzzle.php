<?php

/**
 * Created by PhpStorm.
 * User: ian, Cryotech
 * Date: 8/19/16
 * Time: 9:52 AM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';

abstract class Puzzle
{
    protected static $type = null;
    protected static $generator_path = null;

    public function __construct()
    {
    }

    public function createNewPuzzleTable()
    {
        $sql = "CREATE TABLE " . static::$type . " (username VARCHAR (38) NOT NULL UNIQUE,
                                                    datacache VARCHAR (32000),
                                                    level INTEGER,
                                                    maxlevel INTEGER ,
                                                    PRIMARY KEY (username));";
        $stmt = Database::connect()->prepare($sql);
        return $stmt->execute();
    }

    public function getPuzzleData($user, $level = null)
    {
        $cache = $this->getCachedLevelData($user);
        if (!$cache or $level > $cache['maxlevel']) return false; // User not found or user attempting to access level higher than maxlevel

        if ($level === null) $level = $cache['maxlevel']; // Default to max level if none specified
        if ($cache['level'] != $level or $cache['datacache'] === null)
        {
            $root = realpath($_SERVER['DOCUMENT_ROOT']); // Website root
            $output_file = $user . $level . '_' . static::$type . "_output.txt"; // e.g. amadeus10_sudoku_output.txt
            exec($root . '/' . static::$generator_path . ' ' . $output_file . ' ' . $user . ' ' . $level); // Path Output_File User Level
            $file = getcwd() . '/' . $output_file; // e.g. Current_dir\amadeus10_sudoku_output.txt
            $handle = fopen($file, "r");
            if ($handle)
            {
                $data = null;
                while (!feof($handle))
                    $data .= fgets($handle);

                fclose($handle);
                unlink($file);
            }
            else
                throw new Exception("Output file does not properly exist or generator failed.");

            $sql = "UPDATE " . static::$type . " SET datacache=:datacache, level=:level WHERE username=:username;";
            $stmt = Database::connect()->prepare($sql);
            $stmt->bindParam(":datacache", $data);
            $stmt->bindParam(":level", $level);
            $stmt->bindParam(":username", $user);
            $stmt->execute();
            $cache = $this->getCachedLevelData($user);
        }
        return $cache;
    }

    protected function incrementMaxLevel($user)
    {
        $sql = "UPDATE " . static::$type . " SET maxlevel=maxlevel+1 WHERE username=:user;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":user", $user);
        return $stmt->execute();
    }

    protected function getCachedLevelData($user)
    {
        $sql = "SELECT * FROM " . static::$type . " WHERE username=:user LIMIT 1;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":user", $user);
        $stmt->execute();
        return $stmt->fetch();
    }

    public abstract function verifySolution($user, $level, $solution);


    public function getTopPlayers($number)
    {
        if (is_int($number))
        {
            $sql = "SELECT username, maxlevel FROM " . static::$type . " ORDER BY maxlevel DESC LIMIT " . $number;
            $stmt = Database::connect()->prepare($sql);
            $stmt->bindParam(":user", $user);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Key/ value pairs only
        }
        return false;
    }

    public function createPuzzleUser($user, $level = 0, $maxlevel = 0, $data = null)
    {
        $sql = "INSERT INTO " . static::$type . " (username, datacache, level, maxlevel) VALUES (:user, :data, :level, :mlevel) ON DUPLICATE KEY UPDATE username=:user, datacache=:data, level=:level, maxlevel=:mlevel;";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":level", $level);
        $stmt->bindParam(":mlevel", $maxlevel);
        $stmt->bindParam(":data", $data);
        $stmt->execute();
    }
}
