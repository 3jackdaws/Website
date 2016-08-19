<?php
set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Database.php';
$db = Database::connect();
echo $db->query("CREATE TABLE users
(
username VARCHAR (16) NOT NULL UNIQUE,
email VARCHAR (64),
token VARCHAR (60),
passwd VARCHAR(60),
PRIMARY KEY (username)
);");
echo "<br><br>";
echo $db->query("CREATE TABLE sudoku
(
username VARCHAR (38) NOT NULL UNIQUE,
datacache VARCHAR (32000),
level INTEGER,
maxlevel INTEGER ,
PRIMARY KEY (username),
FOREIGN KEY (username)
);");
echo "<br><br>";
echo $db->query("CREATE TABLE modules
(
guid VARCHAR (38) NOT NULL UNIQUE,
name VARCHAR (32),
type VARCHAR (64),
belongs_to VARCHAR (38),
updated TIMESTAMP,
data TEXT (65400),
PRIMARY KEY (guid)
);");