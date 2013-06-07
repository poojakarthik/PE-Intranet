
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>People Energy Intranet :: Maintenance</title>
<link rel="stylesheet" href="css/flexi-background.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
<script>

var TS_EST = "<?php echo time(); ?>";
function Header_Time_EST()
{
  var a = new Date(TS_EST*1000);
	var hour = a.getHours();
	var min = a.getMinutes();
	var sec = a.getSeconds();
	var period = hour >= 12 ? 'PM' : 'AM';
	hour = hour % 12;
	hour = hour ? hour : 12;
	var time = pad(hour,2) + ':' + pad(min,2) + ' ' + period;
	$( "#clock_time" ).html(time);
	TS_EST++;
}
Header_Time_EST();
setInterval("Header_Time_EST()", 1000);

</script>
</head>

<body>
<div class="logo"></div>

<div id="error_box" style="visibility: hidden;">
<p id="error" style="margin: 0; font-size: 12px"><b>Error</b></p>
</div>

<div id="clock">
<center><p>
<span style="font-size:38px"><?php echo date("d M Y"); ?></span>
<br>
<span id="clock_time"><?php  echo date("h:i A"); ?></span>
</p></center>
</div>

<div class="umaintenance"><p>Sorry Site is Under Maintenance!!</p></div> 
	
</body>
</html>
