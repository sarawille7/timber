<?php
session_start();
unset($_SESSION["username"]);
unset($_SESSION["valid"]);
unset($_SESSION["privileges"]);
if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
	//user is not logged in
	header("Location: login.php");
	die();
}
?>