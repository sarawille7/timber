<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if($_SESSION["privileges"] != "admin") {
	//this is an admin-only page
	header("Location: timber.php");
	die();
}
if(empty($_POST["species"])) {
	//redirect back using header()
	header("Location: admin.php");
	die();
}
try{

	$db = new PDO('sqlite:./myDB/timber.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $species = $_POST["species"];

	$stmt = $db->prepare('INSERT INTO PossibleSpecies VALUES(?)');
	$stmt->execute(array($species));
	$db = null;
} catch(PDOException $e) {
	error_reporting(E_ALL);
	die('Exception : '.$e->getMessage());
}

header("Location: adminSpecies.php");
?>
