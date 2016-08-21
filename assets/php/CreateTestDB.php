<?php
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';
Database::setTestDatabase();
$db = Database::connect();
if(!$db->query("CREATE TABLE users
(
username VARCHAR (16) NOT NULL UNIQUE,
email VARCHAR (64),
token VARCHAR (60),
passwd VARCHAR(60),
PRIMARY KEY (username)
);")){
    var_dump($db->errorInfo());
}
echo "<br><br>";
if(!$db->query("CREATE TABLE sudoku
(
username VARCHAR (38) NOT NULL UNIQUE,
datacache VARCHAR (32000),
level INTEGER,
maxlevel INTEGER ,
PRIMARY KEY (username)
);")){
    var_dump($db->errorInfo());
}
