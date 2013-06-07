<?php
include("../auth/restrict.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>People Energy Intranet :: Main</title>
<link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" type="text/css" media="all" />
<script src="http://code.jquery.com/jquery-1.9.0.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js" type="text/javascript"></script>
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

var current_page = "";

function Page_Load(name,page)
{
	P_Loading_Start();
	$( "#display" ).load("/pages/" + page + ".php", function(data, status, xhr){
		if (status == "error")
		{
			$(".loading_message").html("<p><b>An error occurred while loading the page.</b></p><p><b>Error: " + xhr.status + " " + xhr.statusText + "</b></p>");
			setTimeout(function() {
				P_Loading_End();
			}, 2500);
		}
		else
		{
			if (current_page != "") {
				$( "#menu_" + current_page ).removeClass("active");
			}
			$( "#menu_" + name ).addClass("active");
			current_page = name;
			P_Loading_End();
		}
	});
}

openWins = new Array();

function Page_Load_External(name)
{
	if (name == "files") {
		openWins[1] = window.open("/ajaxplorer","files");
	} else if (name == "email") {
		openWins[2] = window.open("/auth/email.php","email");
	}
}

function Logout()
{
	$.blockUI({ 
		message: '<div class="loading_message"><b>Logging Out...</b></div>',
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
	
	$.post("/auth/logout.php", function(data) {
		setTimeout(function() {
			P_Loading_End();
			if (openWins[1] && !openWins[1].closed) {
				openWins[1].close();
			}
			if (openWins[2] && !openWins[2].closed) {
				openWins[2].close();
			}
			window.location = "/";
		}, 500);
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
<div id="page" class="shell">
	<!-- Logo + Search + Navigation -->
	<div id="top">
	  <div class="cl">&nbsp;</div>
		<h1 id="logo"><a href="/main"></a></h1>
		<div id="clock">
			<center><p>
            <span><?php echo date("d M Y"); ?> - </span><span id="clock_time"><?php echo date("h:i A"); ?></span>
            </p></center>
        </div>
		<div class="cl">&nbsp;</div>
		<div id="navigation">
			<ul>
			    <li>
			    	<a id="menu_home" onclick="Page_Load('home','home')" class="active"><span>Home</span></a>
			    </li>
                <li>
                	<a id="menu_news"><span>News</span></a>
                    <ul>
	   				    <li>
                            <a onclick="Page_Load('news','company')">Company News</a>
                        </li>
                        <li>
                            <a onclick="Page_Load('news','department')">Department News</a>
                        </li>
                    </ul>
                </li>
                <li>
                	<a id="menu_booking"><span>Bookings</span></a>
                    <ul>
	   				    <li>
                            <a onclick="Page_Load('booking','boardroom')">Boardroom</a>
                        </li>
                        <li>
                            <a onclick="Page_Load('booking','meetingroom')">Meeting Room</a>
                        </li>
                        <li>
                            <a onclick="Page_Load('booking','trainingroom')">Training Room</a>
                        </li>
                    </ul>
                </li>
			    <li>
			    	<a id="menu_staff" onclick="Page_Load('staff','staff')"><span>Staff Directory</span></a>
			    </li>
                <li>
			    	<a onclick="Page_Load_External('files')"><span>File Management</span></a>
			    </li>
			    <li>
			    	<a id="menu_eticket" onclick="Page_Load('eticket','eticket')"><span>E-Tickets</span></a>
			    </li>
                <?php
					$p_flag=true;
					$rst=$mysqli->query("Select * from `pen`.`default_priviliges` where user='".$ac['user']."'") or die($mysqli->error);
					if($rst->num_rows==0)
					{
						$rst=$mysqli->query("Select * from `pen`.`shared_privilige` where user='".$ac['user']."'") or die($mysqli->error);
						if($rst->num_rows==0){
							$p_flag=false;
						}
					}
					if($p_flag)
					{
						?>
             	<li>
			    	<a onclick="Page_Load('privilege','privilege')" id="menu_privilege"><span>Privileges</span></a>
			    </li>
                        <?php
					}
					
				?>
                <li>
			    	<a onclick="Logout()"><span>Logout</span></a>
			    </li>
			</ul>
		</div>	
	</div>
	<!-- END Logo + Search + Navigation -->
	<div id="display">
    <script>
	Page_Load('home','home');
	</script>
    </div>
	<!-- Footer -->
	<div id="footer">
    	<?php if (date("Y") == "2013") { $copy_date = date("Y"); } else { $copy_date = "2013 - " . date("Y"); } ?>
		<p class="right">&copy; <?php echo $copy_date; ?> - People Energy</p>
		<div class="cl">&nbsp;</div>
	</div>
	<!-- END Footer -->
	<br />
</div>
</body>
</html>
