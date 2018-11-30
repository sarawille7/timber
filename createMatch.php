<?php
session_start();
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

	$stmt = $db->prepare('INSERT INTO Matches VALUES(?, ?, ?)');
	$stmt->execute(array($matchUser, $matchTree, "datetime('now')"));
	$db = null;
} catch(PDOException $e) {
	die('Exception : '.$e->getMessage());
}

header("Location: findMatches.php");
?>
