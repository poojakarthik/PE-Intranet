<?php
include("../auth/restrict_inner.php");
if(isset($_POST['user']))
{
$user=$_POST['user'];
$pgroup=$_POST['pgroup'];
$query="Select * from pen.users where user!='".$user."'";
$q = $mysqli->query($query) or die($mysqli->error);

$str='
	<table id="box" border=0 cellpadding="0" cellspacing="0" width="80%" style="margin:0 auto;">
		<thead>
			<tr> 
				<td style="text-align:center;">
					 <b>Select One or More Staff to Share <br/> Remove Selection to Stop Share</b>
				</td>
			<tr>
		</thead>
		<tbody>
';

$str.='
			<tr>
				<td style="text-align:center;">
					<select name="staffs" id="staffs" multiple="multiple" size="10" style="width:400px" >
                		';
while($staff = $q->fetch_assoc())
{
	$selected="";
	$qr=$mysqli->query("Select * from pen.shared_privilige where user='".$staff['user']."' and shared_by='".$user."'") or die($mysqli->error);
	if($qr->num_rows==1)
	{
		$selected='selected="selected"';
	}
	$str.="<option value='".$staff['user']."' ".$selected.">".$staff['name']."</option>";
}
$str.='
                	</select>
                </td>
			</tr>
			<tr>
				<td style="text-align:center;">
					<input type="button" value="Save" onclick="saveShare()"/>
				</td>
			</tr>';

$str.='
		</tbody>
	</table>';
	echo $str;
}
else
{
	$mysqli->close();
	header('HTTP/1.1 403 Forbidden');
	exit;
}
?>