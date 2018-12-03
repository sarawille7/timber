<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if($_SESSION["privileges"] != "admin") {
	//this is an admin-only page
	header("Location: timber.php");
	die();
}
if(empty($_GET["username"]) || empty($_GET["banType"])) {
	//redirect back using header()
	header("Location: adminViewUsers.php");
	die();
}
try{

	$db = new PDO('sqlite:./myDB/timber.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $banUser = $_GET["username"];
  $banType = $_GET["banType"];
	$currentTime = new DateTime("NOW");
  $banLength = new DateInterval("PT1M");
  if ($banType == "day") {
    $banLength = new DateInterval("P1D");
  } else if ($banType == "week") {
    $banLength = new DateInterval("P7D");
  } else if ($banType == "month") {
    $banLength = new DateInterval("P28D");
  } else if ($banType == "year") {
    $banLength = new DateInterval("P365D");
  } else if ($banType == "lifetime") {
    $banLength = new DateInterval("P365000D");
  }
	$banDate = $currentTime->add($banLength)->format('Y-m-d H:i:s');
  $stmt = $db->prepare('SELECT banDate FROM banned WHERE username == ?');
  $stmt->execute(array($_GET['username']));
  $result_set = $stmt->fetchAll();
  if (count($result_set) == 0){
    $stmt = $db->prepare('INSERT INTO Banned VALUES(?, ?)');
    $stmt->execute(array($banUser, $banDate));
  } else {
    $stmt = $db->prepare('UPDATE Banned SET banDate = ? WHERE username = ?');
    $stmt->execute(array($banDate, $banUser));
  }

	$db = null;
} catch(PDOException $e) {
	error_reporting(E_ALL);
	die('Exception : '.$e->getMessage());
}

header("Location: adminViewUsers.php");
?>
