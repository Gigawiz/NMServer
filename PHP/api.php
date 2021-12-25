<?php
//include any php files in the includes directory.
foreach (glob(__DIR__."/classes/*.class.php") as $filename)
{
	include_once $filename;
}

if (!isset($_GET['c']) || empty($_GET['c']))
{
	die("Unauthorized Access Detected!");
}

$command = $_GET['c'];

switch($command)
{
	case "game-version":
		echo "2";
	break;
	case "launcher-version":
		echo "1";
	break;
	case "server-status":
		echo "Online";
	break;
	case "onlineplayers":
		echo "10";
	break;
	case "launcher-hash":
		echo "a1f686b869decaa6";
	break;
	case "client-link":
		//$a = ['http://thecrimson.tk/vindictus/latest.zip', 'http://bloodreddawn.com/vindictus/latest.zip'];
		//echo $a[mt_rand(0, count($a) - 1)];
		echo 'https://pewpewkittens.com/vindictus/Balor/Latest.zip';
	break;
	case "launcher-link":
		//$a = ['http://thecrimson.tk/vindictus/latest.zip', 'http://bloodreddawn.com/vindictus/latest.zip'];
		//echo $a[mt_rand(0, count($a) - 1)];
		echo 'http://pewpewkittens.com/vindictus/updater.exe';
	break;
	case "endpoint":
		$buildKey = (isset($_GET['buildver']) ? $_GET['buildver'] : '');
		$endpoint = new Endpoint($buildKey);
		echo $endpoint->endpoint;
	break;
	case "login":
		set_time_limit(2400);    
		ini_set('session.gc_maxlifetime', 2400);
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if (!empty($_POST['userID']) && isset($_POST['userID']) && !empty($_POST['password']) && isset($_POST['password']))
			{	
				$user = new User();
				$user->username = $_POST['userID'];
				$user->password =  $_POST['password'];
				if (!$user->Login())
				{
					echo "Username or Password not set!";
					return;
				}
				$cookie = $user->cookie;
				if (!is_null($cookie))
				{
					setcookie("NPPv2", $cookie);
					echo "Logged In!";
				}
				else {
					echo "Invalid username or password!";
				}
			}
			else {
				echo "Username or Password not set!";
			}
		}
		break;
	case "register":
		set_time_limit(2400);    
		ini_set('session.gc_maxlifetime', 2400);
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if (!empty($_POST['userID']) && isset($_POST['userID']) && !empty($_POST['password']) && isset($_POST['password']))
			{	
				$user = new User();
				$user->username = $_POST['userID'];
				$user->password =  $_POST['password'];
				echo $user->Register();
			}
			else {
				echo "Username or Password not set!";
			}
		}
		break;
	default:
		die("Unautorized Access Detected!");
	break;
}
?>