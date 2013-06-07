<?php
include("../auth/restrict_inner.php");
if(isset($_POST['user']))
{
$user=$_POST['user'];

$q = $mysqli->query("Select * from pen.users where user='".$user."'") or die($mysqli->error);
$staff = $q->fetch_assoc();
$str='
	<table id="user-detail" border=0 cellpadding="0" cellspacing="0" width="80%" style="margin:0 auto;">
		<thead>
			<tr>
				<td colspan="2">
					 <b>More Details for '.$staff['name'].'</b>
				</td>
			<tr>
		</thead>
		<tbody>
';
$str.='
			<tr>
				<td style="text-align:right;" width="30%">
					Staff ID
				</td>
				<td style="text-align:left;padding-left:10px" width="70%">
					'.$staff['staff_id'].'
				</td>
			</tr>';
$str.='
			<tr>
				<td style="text-align:right;">
					Payroll ID
				</td>
				<td style="text-align:left;padding-left:10px">
					'.$staff['payroll_id'].'
				</td>
			</tr>';
$str.='
			<tr>
				<td style="text-align:right;">
					Orion ID
				</td>
				<td style="text-align:left;padding-left:10px">
					'.$staff['orion_id'].'
				</td>
			</tr>';
$str.='
			<tr>
				<td style="text-align:right;">
					P Tag
				</td>
				<td style="text-align:left;padding-left:10px">
					'.$staff['p_tag'].'
				</td>
			</tr>';
$str.='
			<tr>
				<td style="text-align:right;">
					Access Card
				</td>
				<td style="text-align:left;padding-left:10px">
					'.$staff['access_card'].'
				</td>
			</tr>';
$str.='
			<tr>
				<td style="text-align:right;">
					Parking Space
				</td>
				<td style="text-align:left;padding-left:10px">
					'.$staff['parking_space'].'
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