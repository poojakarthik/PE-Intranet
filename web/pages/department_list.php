<?php
include("../auth/restrict_inner.php");
$str='<select name="department" id="department">
	<option value="">Filter By Department</option>';
$q = $mysqli->query("Select distinct department from pen.users where department!=''") or die($mysqli->error);
while ($department = $q->fetch_assoc())
{
	$str.='<option value="'.$department['department'].'">'.$department['department'].'</option>';
 }

$str.='</select>';
echo $str;
?>