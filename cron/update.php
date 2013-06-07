<?php

$mysqli = new mysqli('localhost','pen','18450be');

exec("touch /var/www/maintenance.php");

define('SALT', 'IISp3dwbJu4UuMxWJWSfLrzR');

function encrypt($text)
{
	return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}

function decrypt($text)
{
	return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

// loop to get all users and encrypted password

$q = $mysqli->query("SELECT `user`,`pass` FROM `pen`.`users`") or die($mysqli->error);

//start loop - to update all users

while($data = $q->fetch_assoc())
{
	$user = $data['user']; //user from database
	$pass = $data['pass']; //change to password grabbed from DB
	$pass = decrypt($pass);
	
	$ldap = ldap_connect("ldap://192.168.103.10") or sendError("<b>Error: </b>" . ldap_error($ldap));
	ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
	
	if ($ldap)
	{
		$ldapb = ldap_bind($ldap, $user.'@peteam.com.au', $pass);
		if ($ldapb)
		{
			$dc = "CN=users,DC=peteam,DC=com,DC=au";
			$f = "(sAMAccountName=$user)";
			$attr = array("displayName","description","title","department","company","mail","ipPhone","useraccountcontrol");
			
			$s = ldap_search($ldap,$dc,$f,$attr) or die("<b>Error: </b>Unable to search LDAP server.");
			$d = ldap_get_entries($ldap,$s);
			
			$name = $d[0]["displayname"][0];
			$department = $d[0]["department"][0];
			$position = $d[0]["title"][0];
			$email_type = $d[0]["company"][0];
			$email = $d[0]["mail"][0];
			$extension = $d[0]["ipPhone"][0];
			$status_code = $d[0]["useraccountcontrol"][0];
			
			$mysqli->query("UPDATE `pen`.`users` SET `user`='" . $mysqli->real_escape_string($user) . "',`pass` = '" . $mysqli->real_escape_string(encrypt($pass)) . "', `name` = '" . $mysqli->real_escape_string($name) . "', `department` = '" . $mysqli->real_escape_string($department) . "', `position` = '" . $mysqli->real_escape_string($position) . "', `email_type` = '" . $mysqli->real_escape_string($email_type) . "', `email` = '" . $mysqli->real_escape_string($email) . "', `extension` = '" . $mysqli->real_escape_string($extension) . "', `status` = 'Enabled' WHERE `user` = '" . $mysqli->real_escape_string($user) . "' AND `pass` = '" . $mysqli->real_escape_string(encrypt($pass)) . "'") or die($mysqli->error);
			
		}
		else
		{
			echo "<b>Error: </b>can't authenticate user"; //can't authenticate user email/directory
		}
	}
	else
	{
		break;
		echo "Sorry cant connect to ldap"; //can't connect to ldap
	}
		ldap_close($ldap);
}
//end loop
$q->free();
$mysqli->close();
exec("rm /var/www/maintenance.php");

?>