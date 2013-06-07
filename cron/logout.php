<?php
$mysqli = new mysqli("localhost","pen","18450be");

$mysqli->query("TRUNCATE TABLE `pen`.`current`") or die($mysqli->error);

$mysqli->close();
?>