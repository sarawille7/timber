<?php
session_start();
	//take contents of user_form.html via post request
	//check username and password fields not empty
	//if empty, redirect back to input form using header() function
	//this shouldn't happen anyway, since checks are done before submitting the form
	//if no errors, insert the datra into the database and display success note
if(empty($_POST["username"]) || empty($_POST["password"])) {
	//redirect back to input form using header()
	header("Location: /user_form.php");
	die();
} 
try{
    $hashed_password = password_hash ( $_POST["password"] , PASSWORD_DEFAULT );
	$db = new PDO('sqlite:./myDB/timber.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('INSERT INTO users(username, password, privileges) VALUES(?,?, "general")');
	$stmt->execute(array($_POST["username"],$hashed_password));
	$db = null;
} catch(PDOException $e) {
	echo "That username is taken. ";
	echo "<a class='option' href = \"user_form.php\">Try Again</a>";
	die();
}
$_SESSION['valid'] = TRUE;
$_SESSION['username'] = $_POST["username"];
$_SESSION['privileges'] = "general";
header("Location: userProfile.php");
?>