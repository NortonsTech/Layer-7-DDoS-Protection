LAYER 7 DDOS PROTECTION MADE WITH PHP!

Make sure to include this at the top of every page (or use this on a config.php)

$cookie_label = 'dos_key';
$remote_ip = $_SERVER['CF-Connecting-IP'];	
$salt = "your salt"; //CHANGE THIS
$cookie = md5($remote_ip . ':' . $salt);

if ($_COOKIE[$cookie_label] != $cookie) {
	header('Location: https://website.com/firewall.php'); //set location if firewall not complete
}
