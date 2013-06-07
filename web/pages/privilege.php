<?php
include("../auth/restrict_inner.php");
$rst=$mysqli->query("Select * from `pen`.`default_priviliges` where user='".$ac['user']."'") or die($mysqli->error);
if($rst->num_rows==0)
{
	$rst=$mysqli->query("Select * from `pen`.`shared_privilige` where user='".$ac['user']."'") or die($mysqli->error);
	if($rst->num_rows==0)
	{
		$mysqli->close();
		header('HTTP/1.1 403 Forbidden');
		exit;
	}
}
$pv=$rst->fetch_assoc();
?>
<style>
input[type=button]  {
	background: url(../images/button.png) no-repeat;
	border: none;
	width: 203px;
	height: 44px;
	cursor: pointer;
	font-size:16px;
	font-weight:bold;
	text-align:center;
	color: #333;
	text-shadow:0px 1px 0px rgba(255,255,255,0.35);
}
div#users-contain table { margin: 1em 0; border-collapse: collapse; background:none; }
div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
div#users-contain table td { border: 1px solid #eee; padding: .6em 5px; text-align: left; }
div#users-contain table tbody tr:hover { background: #eee; }
div#users-contain table tbody tr.detail-row:hover { background: none; }
div#users-contain #user-detail tbody tr td { border: #none; }
.close{
	cursor:pointer;	
}
</style>
<!-- Main -->
<div id="main">
	<table width="100%" style="margin-bottom: 10px;">
    <tr>
    <td colspan="2"><h2>Manage Privileges</h2></td>
    </tr>
    </table>
    <div id="display2" style="width: 100%;">
    <script>		
		$(function() {
			$( "#display2" ).load("/pages/privilige_list.php?pgroup=<?php echo $pv['privilige_group'];?>");
		});
		function saveShare(){
			staffs="";
			$('#staffs :selected').each(function(i, selected){ 
			  staffs+= $(selected).val()+"~"; 
			});	
			$.post("../pages/save_share_list.php",{"user":"<?php echo $ac['user'];?>","pgroup":"<?php echo $pv['privilige_group'];?>","staffs":staffs},function(data){
				if(data=="Success")
				{
					$( "#display2" ).load("/pages/privilige_list.php?pgroup=<?php echo $pv['privilige_group'];?>&mode=Saved");
				}
				else{
					alert(data);	
				}
			});
		}
	</script>
    </div>
</div>
<!-- END Main -->