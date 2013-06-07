<script src="http://code.jquery.com/jquery-1.9.0.min.js" type="text/javascript"></script>
<?php
$mysqli = new mysqli('localhost','pen','18450be');

define('SALT', 'IISp3dwbJu4UuMxWJWSfLrzR');

function decrypt($text)
{
	return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

if (isset($_COOKIE["pen_token"])) {
	$token = $_COOKIE["pen_token"];
} else {
	echo "<h1>Not Logged In</h1>";
	$mysqli->close();
	exit;
}

$q = $mysqli->query("SELECT `user` FROM `pen`.`current` WHERE `token` = '" . $mysqli->real_escape_string($token) . "'") or die($mysqli->error);
$user = $q->fetch_row();
if ($q->num_rows == 0)
{
	echo "<h1>Not Logged In</h1>";
	$q->free();
	$mysqli->close();
	exit;
}
$q->free();

$q = $mysqli->query("SELECT `email_type`, `email`, `pass` FROM `pen`.`users` WHERE `user` = '" . $mysqli->real_escape_string($user[0]) . "'") or die($mysqli->error);
$data = $q->fetch_assoc();
$q->free();
$mysqli->close();

$email_type = $data["email_type"];
$email = $data["email"];
$password = decrypt($data["pass"]);

if ($email_type == "gmail")
{
?>
<form method="post" action="https://accounts.google.com/ServiceLoginAuth" id="form">
<input type="hidden" name="service" value="mail" />
<input type="hidden" name="Email" value="<?php echo $email; ?>" />
<input type="hidden" name="continue" value="https://mail.google.com/mail/" />
</form>
<?php
}
elseif ($email_type == "legacy")
{
?>
Do Stuff
<?php
}
else
{
	echo "<h1>Error! Please contact your administrator!</h1>";
	exit;
}
?>
<script>
$( "#form" ).submit();
</script>