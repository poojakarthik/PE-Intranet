<?php
$mysqli = new mysqli("localhost","pen","18450be");

if (isset($_COOKIE["pen_token"]))
{
	$token = $_COOKIE["pen_token"];
	$q = $mysqli->query("SELECT `user` FROM `pen`.`current` WHERE `token` = '" . $mysqli->real_escape_string($token) . "'") or die($mysqli->error);
	$user = $q->fetch_row();
	if ($q->num_rows == 0)
	{
		$q->free();
		$mysqli->close();
		header('HTTP/1.1 403 Forbidden');
		exit;
	}
	$q->free();
	
	$q = $mysqli->query("SELECT `user`, `name`, `department`, `position` FROM `pen`.`users` WHERE `user` = '" . $mysqli->real_escape_string($user[0]) . "'") or die($mysqli->error);
	$ac = $q->fetch_assoc();
	$q->free();
}
else
{
	$mysqli->close();
	header('HTTP/1.1 403 Forbidden');
	exit;
}
?>