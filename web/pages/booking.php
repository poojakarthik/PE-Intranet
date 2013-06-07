<?php
include("../auth/restrict_inner.php");

$room = $_GET["room"];
$date = $_GET["date"];

$booking = array();
$q = $mysqli->query("SELECT `booking`.`time`, `users`.`name` FROM `pen`.`booking`, `pen`.`users` WHERE `booking`.`date` = '" . $mysqli->real_escape_string($date) . "' AND `booking`.`room` = '" . $mysqli->real_escape_string($room) . "' AND `booking`.`bookee` = `users`.`user`") or die($mysqli->error);
while ($book = $q->fetch_assoc())
{
	$booking[$book["time"]] = $book["name"];
}
$q->free();
?>
<table width="100%">
<tr>
<td width="50%" valign="top">
<div id="users-contain" class="ui-widget">
<table id="users" class="ui-widget ui-widget-content" style="width:100%; margin-top:0;">
<thead>
<tr class="ui-widget-header ">
<th width="25%">Time</th>
<th width="70%">Availability</th>
<th width="5%"></th>
</tr>
</thead>
<tbody>
<?php
$start = "08:00";
$end = "12:30";

$tStart = strtotime($start);
$tEnd = strtotime($end);
$tNow = $tStart;

while($tNow <= $tEnd)
{
	$time = date("H:i",$tNow);
	echo "<tr>";
	echo "<td>" . date("H:i",$tNow) . " - " . date("H:i",strtotime("+30 minutes",$tNow)) . "</td>";
	if ($booking[date("H:i",$tNow) . ":00"] != "") {
		echo "<td>Unavailable - " . $booking[date("H:i",$tNow) . ":00"] . "</td>";
	} else {
		echo "<td>Available</td>";
	}
	if ($booking[date("H:i",$tNow) . ":00"] == "") {
		echo "<td><button class='book' onclick='Book(\"$time\")' title='Book Room'></button></td>";
	} elseif ($booking[date("H:i",$tNow) . ":00"] == $ac["name"] || $ac["department"] == "HR") {
		echo "<td><button class='cancel' onclick='Cancel(\"$time\")' title='Cancel'></button></td>";
	} else {
		echo "<td><button class='cancel' disabled></button></td>";
	}
	echo "</tr>";
	$tNow = strtotime('+30 minutes',$tNow);
}
?>
</tbody>
</table>
</div>
</td>
<td width="50%" valign="top">
<div id="users-contain" class="ui-widget">
<table id="users" class="ui-widget ui-widget-content" style="width:100%; margin-top:0;">
<thead>
<tr class="ui-widget-header ">
<th width="25%">Time</th>
<th width="70%">Availability</th>
<th width="5%"></th>
</tr>
</thead>
<tbody>
<?php
$start = "13:00";
$end = "17:30";

$tStart = strtotime($start);
$tEnd = strtotime($end);
$tNow = $tStart;

while($tNow <= $tEnd)
{
	$time = date("H:i",$tNow);
	echo "<tr>";
	echo "<td>" . date("H:i",$tNow) . " - " . date("H:i",strtotime("+30 minutes",$tNow)) . "</td>";
	if ($booking[date("H:i",$tNow) . ":00"] != "") {
		echo "<td>Unavailable - " . $booking[date("H:i",$tNow) . ":00"] . "</td>";
	} else {
		echo "<td>Available</td>";
	}
	if ($booking[date("H:i",$tNow) . ":00"] == "") {
		echo "<td><button class='book' onclick='Book(\"$time\")' title='Book Room'></button></td>";
	} elseif ($booking[date("H:i",$tNow) . ":00"] == $ac["name"] || $ac["department"] == "HR") {
		echo "<td><button class='cancel' onclick='Cancel(\"$time\")' title='Cancel'></button></td>";
	} else {
		echo "<td><button class='cancel' disabled></button></td>";
	}
	echo "</tr>";
	$tNow = strtotime('+30 minutes',$tNow);
}
?>
</tbody>
</table>
</div>
</td>
</tr>
</table>