<?php
session_start();
	//take contents of tree_form.html via post request
	//check tree fields not empty... name, photo, rings, description, species, height
	//if empty, redirect back to input form using header() function
	//this shouldn't happen anyway, since checks are done before submitting the form
	//if no errors, insert the datra into the database and display success note
if(empty($_POST["treename"]) || empty($_FILES["photo"]) || empty($_POST["rings"]) || empty($_POST["description"]) || empty($_POST["species"]) || empty($_POST["height"])) {
	//redirect back to input form using header()
	header("Location: tree_form.php");
	die();
} 
try{
  $photo = crc32(uniqid());
  $treename = $_POST["treename"];
  $dir = "images/";
  $file = $dir . $photo;//basename($_FILES["photo"]["name"]);
  // Check if it's an image file
  if(isset($_FILES["photo"])) {
    $check = getimagesize($_FILES["photo"]['tmp_name']);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        if (move_uploaded_file($_FILES["photo"]['tmp_name'], $file)) {
            //echo "The file has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            die();
        }
        } else {
        echo "File is not an image.";
        die();
    }
  }
  
	$db = new PDO('sqlite:./myDB/timber.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('INSERT INTO trees(treeID, username, name, photoID, rings, descript, species, height) VALUES(?,?, ?, ?, ?, ?, ?, ?)');
	$stmt->execute(array(crc32(uniqid()), $_SESSION["username"], $_POST["treename"],$photo, $_POST["rings"], $_POST["description"], $_POST["species"], $_POST["height"]));
	$db = null;
} catch(PDOException $e) {
	die('Exception : '.$e->getMessage());
}
//$_SESSION['valid'] = TRUE;
//$_SESSION['username'] = $_POST["username"];
header("Location: userProfile.php");
?>