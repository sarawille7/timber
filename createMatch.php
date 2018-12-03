<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if(empty($_POST["username"]) || empty($_POST["treeID"])) {
	//redirect back using header()
	header("Location: findMatches.php");
	die();
}
try{

	$db = new PDO('sqlite:./myDB/timber.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $matchUser = $_POST["username"];
  $matchTree = $_POST["treeID"];
	$currentTime = new DateTime("NOW");
	$matchDate = $currentTime->format('Y-m-d H:i:s');

	$stmt = $db->prepare('INSERT INTO Matches VALUES(?, ?, ?)');
	$stmt->execute(array($matchUser, $matchTree, $matchDate));
	$db = null;
} catch(PDOException $e) {
	error_reporting(E_ALL);
	die('Exception : '.$e->getMessage());
}

header("Location: findMatches.php");
?>
