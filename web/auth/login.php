<?php
$mysqli = new mysqli('localhost','pen','18450be');

define('SALT', 'IISp3dwbJu4UuMxWJWSfLrzR');

function encrypt($text)
{
	return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}

function decrypt($text)
{
	return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

$user = $_POST['user'];
$pass = $_POST['pass'];

if ($user == "" || $pass == "")
{
	echo "<b>Error: </b>Incorrect Username or Password.";
	exit;
}

$pass = encrypt($pass);

$q = $mysqli->query("SELECT `user` FROM `pen`.`users` WHERE `user` = '" . $mysqli->real_escape_string($user) . "' AND `pass` = '" . $mysqli->real_escape_string($pass) . "'") or die($mysqli->error);
$data = $q->fetch_assoc();

if ($q->num_rows != 0)
{
	if ($data["status"] == "Disabled")
	{
		echo "<b>Error: </b>Your account is disabled.";
	}
	else
	{
		$token = hash('whirlpool', $user . rand());
		setcookie("pen_token", $token, strtotime("+1 month"), '/');
		
		$mysqli->query("INSERT INTO `pen`.`current` (`user`, `token`, `timestamp`) VALUES ('" . $mysqli->real_escape_string($user) . "', '" . $mysqli->real_escape_string($token) . "', NOW()) ON DUPLICATE KEY UPDATE `token` = '" . $mysqli->real_escape_string($token) . "', `timestamp` = NOW()") or die($mysqli->error);
		
		define("AJXP_EXEC", true);
		$glueCode = "/usr/share/ajaxplorer/plugins/auth.remote/glueCode.php";
		$secret = "kjsdoi3kjn3";
	
		// Initialize the "parameters holder"
		global $AJXP_GLUE_GLOBALS;
		$AJXP_GLUE_GLOBALS = array();
		$AJXP_GLUE_GLOBALS["secret"] = $secret;
		$AJXP_GLUE_GLOBALS["plugInAction"] = "login";
		$AJXP_GLUE_GLOBALS["autoCreate"] = false;
	
		// NOTE THE md5() call on the password field.
		$AJXP_GLUE_GLOBALS["login"] = array("name" => $_POST["user"], "password" => md5($_POST["pass"]));
	
		// NOW call glueCode!
		include($glueCode);
		
		echo "success";
	}
}
else
{
	$pass = decrypt($pass);

	$ldap = ldap_connect("ldap://192.168.103.10") or sendError("<b>Error: </b>" . ldap_error($ldap));
	ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);

	if ($ldap)
	{
		$ldapb = ldap_bind($ldap, $user.'@peteam.com.au', $pass);

		if ($ldapb)
		{
			$dc = "CN=Users,DC=peteam,DC=com,DC=au";
			$f = "(sAMAccountName=$user)";
			$attr = array("displayName","description","title","department","telephonenumber","facsimiletelephonenumber","company","mail","ipPhone","useraccountcontrol","info");
			$s = ldap_search($ldap,$dc,$f,$attr) or die("<b>Error: </b>Unable to search LDAP server.");
			$d = ldap_get_entries($ldap,$s);
			
			//var_dump($d);
			$name = $d[0]["displayname"][0];
			$department = $d[0]["department"][0];
			$position = $d[0]["title"][0];
			$email_type = $d[0]["company"][0];
			$email = $d[0]["mail"][0];
			$extension = $d[0]["ipPhone"][0];
			$status_code = $d[0]["useraccountcontrol"][0];
			$phone_number = $d[0]["telephonenumber"][0];
			$fax_number = $d[0]["facsimiletelephonenumber"][0];
			$additional_info=$d[0]["info"][0];
			
			$info=explode("~",$additional_info);
			$staff_id=0;
			$payroll_id=0;
			$location="";
			$orion_id=0;
			$p_tag=0;
			$access_card=0;
			$parking_space="";
			//echo $additional_info;
			$i=0;
			while($i<sizeof($info))
			{
				$temp=explode("=",$info[$i]);
				switch (ltrim($temp[0]))
				{
					case 'StaffID':
						$staff_id=$temp[1];
						//echo "Staff ID:".$staff_id;
						break;	
					case 'PayRollID':
						$payroll_id=$temp[1];
						//echo "PayRollID:".$payroll_id;
						break;	
					case 'Location':
						$location=$temp[1];
						//echo "Location:".$location;
						break;	
					case 'OrionID':
						$orion_id=$temp[1];
						//echo "OrionID:".$orion_id;
						break;	
					case 'PTag':
						$p_tag=$temp[1];
						//echo "PTag:".$p_tag;
						break;	
					case 'AccessCard':
						$access_card=$temp[1];
						//echo "AccessCard:".$access_card;
						break;	
					case 'ParkingSpace':
						$parking_space=$temp[1];
						//echo "ParkingSpace:".$parking_space;
						break;	
					default:
						continue;
				}
				$i++;	
			}
			
			$mysqli->query("INSERT INTO `pen`.`users` (`user`, `pass`, `name`, `department`, `position`, `staff_id`, `payroll_id`, `location`, `email_type`, `email`, `orion_id`, `phone_number`, `extension`, `fax_number`, `p_tag`, `access_card`, `parking_space`, `status`) VALUES ('" . $mysqli->real_escape_string($user) . "', '" . $mysqli->real_escape_string(encrypt($pass)) . "', '" . $mysqli->real_escape_string($name) . "', '" . $mysqli->real_escape_string($department) . "', '" . $mysqli->real_escape_string($position) . "', '" . $mysqli->real_escape_string($staff_id) . "', '" . $mysqli->real_escape_string($payroll_id) . "', '" . $mysqli->real_escape_string($location) . "', '" . $mysqli->real_escape_string($email_type) . "', '" . $mysqli->real_escape_string($email) . "', '" . $mysqli->real_escape_string($orion_id) . "', '" . $mysqli->real_escape_string($phone_number) . "', '" . $mysqli->real_escape_string($extension) . "', '" . $mysqli->real_escape_string($fax_number) . "', '" . $mysqli->real_escape_string($p_tag) . "', '" . $mysqli->real_escape_string($access_card) . "', '" . $mysqli->real_escape_string($parking_space) . "','Enabled') ON DUPLICATE KEY UPDATE `pass` = '" . $mysqli->real_escape_string(encrypt($pass)) . "', `name` = '" . $mysqli->real_escape_string($name) . "', `department` = '" . $mysqli->real_escape_string($department) . "', `position` = '" . $mysqli->real_escape_string($position) . "', staff_id='".$mysqli->real_escape_string($staff_id) . "', payroll_id='" . $mysqli->real_escape_string($payroll_id) . "', location='" . $mysqli->real_escape_string($location) . "', `email_type` = '" . $mysqli->real_escape_string($email_type) . "', `email` = '" . $mysqli->real_escape_string($email) . "',orion_id='" . $mysqli->real_escape_string($orion_id) . "', phone_number='" . $mysqli->real_escape_string($phone_number) . "', `extension` = '" . $mysqli->real_escape_string($extension) . "', fax_number='" . $mysqli->real_escape_string($fax_number) . "', p_tag ='" . $mysqli->real_escape_string($p_tag) . "', access_card='" . $mysqli->real_escape_string($access_card) . "', parking_space ='" . $mysqli->real_escape_string($parking_space) . "', `status` = 'Enabled'") or die($mysqli->error);
			
			$mysqli->query("INSERT INTO `pen`.`ajxp_users` (`login`, `password`) VALUES ('" . $mysqli->real_escape_string($user) . "', '" . $mysqli->real_escape_string(md5($pass)) . "')") or die($mysqli->error);
			
			$token = hash('whirlpool', $user . rand());
			setcookie("pen_token", $token, strtotime("+1 month"), '/');
			
			$mysqli->query("INSERT INTO `pen`.`current` (`user`, `token`, `timestamp`) VALUES ('" . $mysqli->real_escape_string($user) . "', '" . $mysqli->real_escape_string($token) . "', NOW()) ON DUPLICATE KEY UPDATE `token` = '" . $mysqli->real_escape_string($token) . "', `timestamp` = NOW()") or die($mysqli->error);
			
			define("AJXP_EXEC", true);
			$glueCode = "/usr/share/ajaxplorer/plugins/auth.remote/glueCode.php";
			$secret = "kjsdoi3kjn3";
		
			// Initialize the "parameters holder"
			global $AJXP_GLUE_GLOBALS;
			$AJXP_GLUE_GLOBALS = array();
			$AJXP_GLUE_GLOBALS["secret"] = $secret;
			$AJXP_GLUE_GLOBALS["plugInAction"] = "login";
			$AJXP_GLUE_GLOBALS["autoCreate"] = false;
		
			// NOTE THE md5() call on the password field.
			$AJXP_GLUE_GLOBALS["login"] = array("name" => $_POST["user"], "password" => md5($_POST["pass"]));
		
			// NOW call glueCode!
			include($glueCode);
			
			echo "success";
		}
		else
		{
			echo "<b>Error: </b>Incorrect Username or Password.";
		}
		
		ldap_close($ldap);
	}
}

$q->free();
$mysqli->close();
?>