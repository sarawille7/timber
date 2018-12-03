<?php
session_start();
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
	die('Exception : '.$e->getMessage());
}

header("Location: adminSpecies.php");
?>
