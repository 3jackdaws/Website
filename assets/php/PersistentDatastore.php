<?php

/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/26/16
 * Time: 12:41 PM
 */
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';

class PersistentDatastore
{
    private $conn;
    private $group;
    private $inner = [];
    public function __construct($group)
    {
        $this->group = $group;
        $this->conn = Database::connect();
        $sql = "SELECT * FROM kv_store WHERE kv_group=:g;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":g", $group);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row){
            $this->inner[$row['kv_key']] = $row['kv_value'];
        }
    }

    public function __destruct()
    {
        $this->save();
    }

    public function set($key, $value){
        $this->inner[$key] = $value;
    }

    public function get($key){
        return $this->inner[$key];
    }

    public function containsKey($key){
        return array_key_exists($key, $this->inner);
    }

    public function save(){
        $sql = "INSERT INTO kv_store (kv_group, kv_key, kv_value) VALUES(:group, :key, :value) ON DUPLICATE KEY UPDATE kv_group=:group, kv_key=:key, kv_value=:value;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":group", $this->group);
        foreach($this->inner as $key=>$value){
            $stmt->bindParam(":key", $key);
            $stmt->bindParam(":value", $value);
            $stmt->execute();
        }

    }
}