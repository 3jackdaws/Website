<?php
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';
echo "Connecting to database<br>";
$db = Database::connect();
if(!$db){
    echo "Could not connect to the database<br>" . $db->errorInfo();
}
if(!$db->query("CREATE TABLE users
(
username VARCHAR (16) NOT NULL UNIQUE,
email VARCHAR (64),
token VARCHAR (60),
passwd VARCHAR(60),
PRIMARY KEY (username)
);")){
    echo $db->errorInfo()[2] . "<br>";
}else{
    echo "Created table users<br>";
}
if(!$db->query("CREATE TABLE sudoku
(
username VARCHAR (38) NOT NULL UNIQUE,
datacache VARCHAR (32000),
level INTEGER,
maxlevel INTEGER ,
PRIMARY KEY (username)
);")){
    echo $db->errorInfo()[2] . "<br>";
}else{
    echo "Created table sudoku<br>";
}

if(!$db->query("CREATE TABLE ip_log
(
ip VARCHAR(15),
action VARCHAR(20),
time TIMESTAMP
);")){
    echo $db->errorInfo()[2] . "<br>";
}else{
    echo "Created table ip_log<br>";
}

if(!$db->query("CREATE TABLE kv_store
(
kv_group VARCHAR(30) NOT NULL,
kv_key VARCHAR(20),
kv_value VARCHAR(1000),
PRIMARY KEY (kv_group,kv_key)
);")){
    echo $db->errorInfo()[2] . "<br>";
}else{
    echo "Created table kv_store<br>";
}
