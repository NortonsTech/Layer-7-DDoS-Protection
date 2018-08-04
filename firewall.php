<?php 

/* VERY BASIC PROTECTION by Norton <33
 * NOTE THIS ISNT THE BEST PROTETION BUT IT WILL DO AGAINST SKIDS
 
SET THIS ON EVERY PAGE, OR USE A CONFIG.PHP TO INCLUDE IT!

$cookie_label = 'dos_key';
$remote_ip = $_SERVER['CF-Connecting-IP'];	
$salt = "your salt"; //CHANGE THIS
$cookie = md5($remote_ip . ':' . $salt);

if ($_COOKIE[$cookie_label] != $cookie) {
	header('Location: https://website.com/firewall.php'); //set location if firewall not complete
}
 
 
 */

error_reporting(0); //STOP ERROR REPORTING

$cookie_label = 'dos_key';
$remote_ip = $_SERVER['CF-Connecting-IP']; //Cloudflare IP Header. Change if you aint using cloudflare!
$salt = "your salt"; //CHANGE THIS
$cookie = md5($remote_ip . ':' . $salt);

if (isset($_COOKIE[$cookie_label]) && $_COOKIE[$cookie_label] == $cookie) {
	header('Location: index.php'); //set location IF they already passed the captcha
}

$response = $_POST["g-recaptcha-response"];
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
	'secret' => '', //<----- SECRET KEY
	'response' => $_POST["g-recaptcha-response"]
);
$options = array(
	'http' => array (
		'method' => 'POST',
		'content' => http_build_query($data)
	)
);

$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success=json_decode($verify);
if ($captcha_success->success==false) {
	
} else if ($captcha_success->success==true) {
	if(empty($_COOKIE['dos_key']))
			{
				// Sets a 30 Mintue Session Before Renew
				setcookie("dos_key", $cookie, time() + 1800);
				header('Location: index.php'); //set location
	}
}
	
?>

<style>
* {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}

img {
  -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
  user-drag: none;
}

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}

</style>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Norton Firewall</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<!-- Custom CSS -->
	<style>
		@keyframes blink {
			0% {
				opacity: 1;
			}
			50% {
				opacity: 0;
			}
			100% {
				opacity: 1;
			}
		}
		img {
			animation: blink 1s;
			animation-iteration-count: infinite;
		}
	</style>
	
  </head>

  <body>

    <!-- Begin page content -->
    <div class="container text-center">
		<div class="row">
				<div class="form-group">
					<div class="jumbotron">
						<img src="assets/imgs/shield.png" height="100" width="100"> <?php //SET IMAGE ?>
						<h1>Norton <font style="color: red;">Firewall</font></h1>
						<p class="lead"><font style="color: red;">0</font>11<font style="color: red;">0</font>111<font style="color: red;">0</font> <font style="color: red;">0</font>11<font style="color: red;">0</font>1111 <font style="color: red;">0</font>11<font style="color: red;">0</font><font style="color: red;">0</font>1<font style="color: red;">0</font><font style="color: red;">0</font> <font style="color: red;">0</font>11<font style="color: red;">0</font><font style="color: red;">0</font>1<font style="color: red;">0</font>1</p>
						<br>
						
						<form action="?" method="post">
						<div class="captcha_wrapper">
							<center><div class="g-recaptcha" data-sitekey="your public key"></div></center> <?php //CHANGE THIS !! ?>
						</div><br>
						<input type="submit" class="button" id="sexy" value="Enter"/>

						</form>
					<br>
				</div> 
			</div>
		</div>
    </div>
	<script src='https://www.google.com/recaptcha/api.js'></script>
  </body>
</html>

