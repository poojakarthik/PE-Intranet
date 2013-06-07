<?php
include("../auth/restrict_inner.php");

$department = $_GET["department"];
$keyword = $_GET["keyword"];

if($department!="")
{
	$department="department='".$department."'";
}
if($keyword!="")
{
	$keyword="(name like '%".$mysqli->real_escape_string($keyword)."%' or department like '%".$mysqli->real_escape_string($keyword)."%' or position like '%".$mysqli->real_escape_string($keyword)."%' or location like '%".$mysqli->real_escape_string($keyword)."%' or email like '%".$mysqli->real_escape_string($keyword)."%' or phone_number like '%".$mysqli->real_escape_string($keyword)."%' or  fax_number like '%".$mysqli->real_escape_string($keyword)."%')";	
}
$query="SELECT * from `pen`.`users`";
$query_append="";
if($department!="" && $keyword!="")
	$query_append.=" where ".$department." and ".$keyword;
else if($department!="")
	$query_append.=" where ".$department;
else if($keyword!="")
	$query_append.=" where ".$keyword;

$q = $mysqli->query($query.$query_append) or die($mysqli->error);
?>
<script>
		
		$('.detail').click(function() {
			var user=$(this).attr("id");
			var temp=user.split("-");
			$.post("../pages/staff_detail.php","user="+temp[0],function(data){
				$('#user-detail').closest('tr').remove();
				$('#users > tbody > tr').eq($('#'+user).closest('tr').index()).after('<tr class="detail-row"><td colspan=5><div style="float:right"><img src="../images/close.png" alt="close" class="close"></div><div style="clear:both;text-align:center;">'+data+'</div></td></tr>');
				$('.close').click(function(){
					$('.close').closest('tr').remove();
				});
			});
		
		});
</script>
<div id="users-contain" class="ui-widget">
<table id="users" width="100%" class="ui-widget ui-widget-content" cellspacing="0">
	<thead>
	<tr class="ui-widget-header " style="padding:5px;">
    	<td width="20%" style="padding:5px;">Name</td>
        <td width="15%" style="padding:5px;">Department</td>
        <td width="15%" style="padding:5px;">Email</td>
        <td width="30%" style="padding:5px;">Contact Details</td>
        <td width="20%" style="padding:5px;">Action</td>
    </tr>
    </thead>
    <tbody>
<?php
while ($staffs = $q->fetch_assoc())
{
	?>
    	<tr style="border-bottom:1px solid #666;">
        	<td style="padding:5px;"><?php echo $staffs['name'];?><br/><?php echo $staffs['position'];?></td>
            <td style="padding:5px;"><?php echo $staffs['department'];?></td>
            <td style="padding:5px;"><?php echo $staffs['email'];?></td>
            <td style="padding:5px;">Phone No.:<?php echo $staffs['phone_number'];?><br/>Extension: <?php echo $staffs['extension'];?><br/>Fax: <?php echo $staffs['fax_number'];?></td>
            <td>
            <?php
			$detail_flag=false;
			$rst=$mysqli->query("Select * from `pen`.`default_priviliges` where user='".$ac['user']."'") or die($mysqli->error);
			if($rst->num_rows==0)
			{
				$rst=$mysqli->query("Select * from `pen`.`shared_privilige` where user='".$ac['user']."'") or die($mysqli->error);
			}
			if($rst->num_rows>0)
			{
				$prvlege=$rst->fetch_assoc();
				if($prvlege['privilige_group']=="M" || $prvlege['privilige_group']=="T")
				{
					$reports_to=$mysqli->query("Select * from `pen`.`reports_to` where user='".$staffs['user']."' and manager='".$ac['name']."'");
					if($reports_to->num_rows>0)
					{
						$detail_flag=true;
					}
				}
				else{
					$detail_flag=true;
				}
			}
			if($detail_flag || $ac['user']==$staffs['user'])
			{
			?>
            <img src="../images/user.png" title="Click here to view more details" alt="View Detail" style="cursor:pointer;" id="<?php echo $staffs['user'];?>-detail" class="detail"/></td>
            <?php
			}
			?>
        </tr>
    <?php
}
$q->free();
?>
	</tbody>
</table>
</div>