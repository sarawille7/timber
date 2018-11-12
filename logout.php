<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["valid"]);
if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
	//user is not logged in
	header("Location: login.php");
	die();
}
?>