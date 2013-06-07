<?php
$mysqli = new mysqli("localhost","pen","18450be");
$action = $_POST["action"];
$room = $_POST["room"];
$date = $_POST["date"];
$time = $_POST["time"];
$bookee = $_POST["bookee"];

if ($action == "book")
{
	$mysqli->query("INSERT INTO `pen`.`booking` (`date`, `time`, `room`, `bookee`) VALUES ('" . $mysqli->real_escape_string($date) . "', '" . $mysqli->real_escape_string($time) . "', '" . $mysqli->real_escape_string($room) . "', '" . $mysqli->real_escape_string($bookee) . "')") or die($mysqli->error);
}
elseif ($action == "cancel")
{
	$mysqli->query("DELETE FROM `pen`.`booking` WHERE `date` = '" . $mysqli->real_escape_string($date) . "' AND `time` = '" . $mysqli->real_escape_string($time) . "' AND `room` = '" . $mysqli->real_escape_string($room) . "'") or die($mysqli->error);
}

$mysqli->close();
?>