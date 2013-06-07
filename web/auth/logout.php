<?php
$mysqli = new mysqli('localhost','pen','18450be');

$token = $_COOKIE["pen_token"];;

if($token == ""){ exit; }

$mysqli->query("DELETE FROM `pen`.`current` WHERE `token` = '" . $mysqli->real_escape_string($token) . "' LIMIT 1") or die($mysqli->error);

setcookie('pen_token', null, time()-3600, '/');

$mysqli->close();
?>