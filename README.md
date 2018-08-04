# LAYER 7 DDOS PROTECTION MADE WITH PHP!

MAKE SURE YOU READ THE TOP OF FIREWALL.PHP!

Add this at the top of every page (or in a config.php)

```php
$cookie_label = 'dos_key';
$remote_ip = $_SERVER['CF-Connecting-IP'];	
$salt = "your salt"; //CHANGE THIS MAKE SURE IT MATCHES FIREWALL.PHP!!
$cookie = md5($remote_ip . ':' . $salt);

if ($_COOKIE[$cookie_label] != $cookie) {
	header('Location: https://website.com/firewall.php'); //set location if firewall not complete
}
```
