<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 8/19/16
 * Time: 4:53 PM
 */

set_include_path(realpath($_SERVER['DOCUMENT_ROOT']) . '/assets/php');
require_once 'Parsedown.php';
sleep(0);

$url = "https://github.com/AutonomousAlgorithms/Documentation/wiki/";
$page = $_GET['page'];

$md = file_get_contents($url . $page . ".md");
error_log($url . $page . ".md");
$html = new Parsedown();
echo $html->text($md);
