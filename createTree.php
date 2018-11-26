<?php
session_start();
	//take contents of tree_form.html via post request
	//check tree fields not empty... name, photo, rings, description, species, height
	//if empty, redirect back to input form using header() function
	//this shouldn't happen anyway, since checks are done before submitting the form
	//if no errors, insert the datra into the database and display success note
if(empty($_POST["treename"]) || empty($_POST["photo"]) || empty($_POST["rings"]) || empty($_POST["description"]) || empty($_POST["species"]) || empty($_POST["height"])) {
	//redirect back to input form using header()
	header("Location: tree_form.php");
	die();
} 
try{
    $treename = $_POST["treename"];
    $photo = password_hash ( $_POST["photo"] , PASSWORD_DEFAULT );
	$db = new PDO('sqlite:./myDB/timber.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('INSERT INTO trees(treeID, username, name, photoID, rings, descript, species, height) VALUES(?,?, ?, ?, ?, ?, ?, ?)');
	$stmt->execute(array(crc32(uniqid()), $_SESSION["username"], $_POST["treename"],crc32(uniqid()), $_POST["rings"], $_POST["description"], $_POST["species"], $_POST["height"]));
	$db = null;
} catch(PDOException $e) {
	die('Exception : '.$e->getMessage());
}
//$_SESSION['valid'] = TRUE;
//$_SESSION['username'] = $_POST["username"];
header("Location: userProfile.php");
?>