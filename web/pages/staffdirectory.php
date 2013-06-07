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
if($department!="" && $keyword!="")
	$query.=" where ".$department." and ".$keyword;
else if($department!="")
	$query.=" where ".$department;
else if($keyword!="")
	$query.=" where ".$keyword;
$q = $mysqli->query($query) or die($mysqli->error);
?>
<table width="100%" class="ui-widget ui-widget-content" cellspacing="0">
	<tr class="ui-widget-header " style="text-align:center; padding:5px;">
    	<td width="30%" style="padding:5px;">Name</td>
        <td width="20%" style="padding:5px;">Department</td>
        <td width="20%" style="padding:5px;">Email</td>
        <td width="30%" style="padding:5px;">Contact Details</td>
    </tr>
<?php
while ($staffs = $q->fetch_assoc())
{
	?>
    	<tr style="border-bottom:1px solid #666;">
        	<td style="padding:5px;"><?php echo $staffs['name'];?><br/><?php echo $staffs['position'];?></td>
            <td style="padding:5px;"><?php echo $staffs['department'];?></td>
            <td style="padding:5px;"><?php echo $staffs['email'];?></td>
            <td style="padding:5px;">Phone No.:<?php echo $staffs['phone_number'];?><br/>Extension: <?php echo $staffs['extension'];?><br/>Fax: <?php echo $staffs['fax_number'];?></td>
        </tr>
    <?php
}
$q->free();
?>
</table>