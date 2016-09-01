<?php

/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/20/16
 * Time: 12:22 AM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';

class SecurityAgent
{
    private $sensitivity;
    private $loginfo = "";
    public function __construct($sensitivity = 20)
    {
        if($sensitivity) $this->sensitivity = $sensitivity;
        $this->checkFrequency();
    }

    public function __destruct()
    {
        $this->LogAction(basename($_SERVER['PHP_SELF']) . ": " . $this->loginfo);
    }

    public function AddLogInfo($message){
        $this->loginfo .= $message;
    }

    public function LogAction($action){
        $now = time();
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO ip_log (ip, action, time) VALUES(:ip, :action, FROM_UNIXTIME(:now));";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":ip", $ip);
        $stmt->bindParam(":action", $action);
        $stmt->bindParam(":now", $now);
        $stmt->execute();
    }

    public function checkFrequency(){
        $timemin1 = time() - 60;
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = "SELECT COUNT(ip) FROM ip_log WHERE ip=:ip AND time > FROM_UNIXTIME(:timemin1);";
        $stmt = Database::connect()->prepare($sql);
        $stmt->bindParam(":ip", $ip);
        $stmt->bindParam(":timemin1", $timemin1);
        $stmt->execute();
        $freq = $stmt->fetch()[0];
        if($freq > $this->sensitivity) trigger_error(self::DISCONNECT_SPAM, E_USER_ERROR);
        else if($freq > 10) sleep($freq - 10);

    }

    const DISCONNECT_SPAM = "Too many requests in a given time.";

}