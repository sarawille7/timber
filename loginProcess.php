<?php
session_start();
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
    echo("User found and verified");
    $_SESSION['valid'] = $verify;
    $_SESSION['username'] = $_POST["username"];
  }
  else {
    echo("Nope, no user here");
  }
	$db = null;
} catch(PDOException $e) {
	die('Exception : '.$e->getMessage());
}
header("Location: showLogin.php?success=true");
?>