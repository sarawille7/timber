<?php
session_start();
if($_SESSION["privileges"] != "admin") {
	//this is an admin-only page
	header("Location: timber.php");
	die();
}
if(empty($_GET["username"])) {
	//redirect back using header()
	header("Location: adminViewUsers.php");
	die();
}
try{

	$db = new PDO('sqlite:./myDB/timber.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $banUser = $_GET["username"];
	$currentTime = new DateTime("NOW");
  $currentTime = $currentTime->format('Y-m-d H:i:s');
  $stmt = $db->prepare('UPDATE Banned SET banDate = ? WHERE username = ?');
  $stmt->execute(array($currentTime, $banUser));
	
	$db = null;
} catch(PDOException $e) {
	die('Exception : '.$e->getMessage());
}

header("Location: adminViewUsers.php");
?>
