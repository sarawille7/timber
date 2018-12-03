<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if(empty($_POST["username"]) || empty($_POST["password"])) {
	//redirect back to input form using header()
	header("Location: login.php");
	die();
}
try{
    $hashed_password = password_hash ( $_POST["password"] , PASSWORD_DEFAULT );
	$db = new PDO('sqlite:./myDB/timber.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT username, privileges, password FROM users WHERE username == ?;');
	$stmt->execute(array($_POST["username"]));
  $result = $stmt->fetch();
  $pass = $result["password"];
  $verify = password_verify($_POST["password"], $pass);
  if ($verify){
    $_SESSION['valid'] = $verify;
    $_SESSION['username'] = $_POST["username"];
    $_SESSION['privileges'] = $result["privileges"];
    header("Location: userProfile.php");
  }
  else {
    echo("Nope, no user here");
  }
	$db = null;
} catch(PDOException $e) {
	error_reporting(E_ALL);
	die('Exception : '.$e->getMessage());
}
?>
