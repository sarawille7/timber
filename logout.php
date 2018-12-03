<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
try{
unset($_SESSION["username"]);
unset($_SESSION["valid"]);
unset($_SESSION["privileges"]);
if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
	//user is not logged in
	header("Location: login.php");
	die();
}
}catch{
		error_reporting(E_ALL);
}
?>
