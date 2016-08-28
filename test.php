<?php
/**
 * Created by PhpStorm.
 * User: Ian Murphy
 * Date: 8/27/2016
 * Time: 8:50 PM
 */

set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once "JSONResponse.php";
require_once "PersistentDatastore.php";

$values = new PersistentDatastore("myvalues");

//$values->set("test", "testvalue");

echo $values->get("test");

$stmt = Database::connect()->prepare("SELECT * FROM ip_log WHERE ip='127.0.0.1';");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    echo $row['action'] . "<br>";

}