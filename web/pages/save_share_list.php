<?php
include("../auth/restrict_inner.php");
if(isset($_POST['user']))
{
	$user=$_POST['user'];
	$pgroup=$_POST['pgroup'];
	$staffs=$_POST['staffs'];
	$mysqli->query("delete from pen.shared_privilige where shared_by='".$user."'") or die($mysqli->error);
	$staff=explode("~",$staffs);
	$i=0;
	while($i<sizeof($staff))
	{
		if($staff[$i]!="")
			$q = $mysqli->query("insert into pen.shared_privilige VALUES ('".$mysqli->escape_string($staff[$i])."','".$mysqli->escape_string($pgroup)."','".$mysqli->escape_string($user)."')") or die($mysqli->error);
		$i++;
	}
	echo "Success";
}
else
{
	$mysqli->close();
	header('HTTP/1.1 403 Forbidden');
	exit;
}
?>