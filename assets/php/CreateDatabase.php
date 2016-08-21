<?php
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';
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
}else{
    echo "Database ''";
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

if(!$db->query("CREATE TABLE ip_log
(
ip VARCHAR(15),
action VARCHAR(20),
time TIMESTAMP
);")){
    var_dump($db->errorInfo());
}
