<?php
$mysqli = new mysqli('localhost','pen','18450be');

if (isset($_COOKIE["pen_token"]))
{
	$token = $_COOKIE["pen_token"];
	$q = $mysqli->query("SELECT `user` FROM `pen`.`current` WHERE `token` = '" . $mysqli->real_escape_string($token) . "'") or die($mysqli->error);
	if ($q->num_rows != 0)
	{
		$q->free();
		$mysqli->close();
		header("Location: /main");
		exit;
	}
	$q->free();
	$mysqli->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>People Energy Intranet :: Login</title>
<link rel="stylesheet" href="css/flexi-background.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
<script src="http://code.jquery.com/jquery-1.9.0.min.js" type="text/javascript"></script>
<script src="/js/flexi-background.js" type="text/javascript"></script>
<script src="/js/blockUI.js" type="text/javascript"></script>
<script>
function pad(number, length) {
	var str = '' + number;
	while (str.length < length) {
		str = '0' + str;
	}
	return str;
}

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

function P_Loading_Start()
{
	$.blockUI({ 
		message: '<div class="loading_message"><b>Loading...</b></div>',
		overlayCSS: {
			cursor: 'default'
		},
		css: { 
			border: 'none', 
			padding: '15px', 
			backgroundColor: '#000', 
			'border-radius': '10px', 
			'-webkit-border-radius': '10px', 
			'-moz-border-radius': '10px', 
			opacity: .5, 
			color: '#fff',
			cursor: 'default'
		}
	});
}

function P_Loading_End()
{
	$.unblockUI();
}

function Login() {
	var user = $( "#user" ),
		pass = $( "#pass" );
	
	P_Loading_Start();
	$.post("auth/login.php", { user: user.val(), pass: pass.val() },
	function(data) {
		if (data == "success") {
			window.location = "/main";
		} else {
			$( "#error" ).html(data);
			$( "#error_box" ).removeAttr("style");
			P_Loading_End();
		}
	}).error( function(xhr, text, err) {
		$(".loading_message").html("<p><b>An error occurred while performing this action.</b></p><p><b>Error: " + xhr.status + " " + xhr.statusText + "</b></p>");
		setTimeout(function() {
			P_Loading_End();
		}, 2500);
	});
}
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
<span id="clock_time"><?php echo date("h:i A"); ?></span>
</p></center>
</div>

<div id="box">
<h1>Member Login</h1>
<form onsubmit="return false;">
<input type="text" id="user" autofocus="autofocus" autocomplete="off" placeholder="Username" />
<input type="password" id="pass" autocomplete="off" placeholder="Password">
<input type="submit" onclick="Login()" value="Log In" />
</form>
</div>
</body>
</html>