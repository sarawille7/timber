<?php
	//take contents of passenger_form.html via post request
	//check firstname lastname and ssn fields not empty
	//if empty, redirect back to input form using header() function
	//this shouldn't happen anyway, since checks are done before submitting the form
	//if no errors, insert the datra into the database and display success note
if(empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["ssn"])) {
	//redirect back to input form using header()
	header("Location: http://54.173.137.240/~ubuntu/passenger_form.html");
	die();
} 
try{
	$db = new PDO('sqlite:./myDB/airport.db');
	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('INSERT INTO passengers VALUES(?,?,?,?)');
	$stmt->execute(array($_POST["firstname"],$_POST["middleinitial"],$_POST["lastname"],$_POST["ssn"]));
	$db = null;
} catch(PDOException $e) {
	die('Exception : '.$e->getMessage());
}
header("Location: http://54.173.137.240/~ubuntu/showPassengers.php?success=true");
?>
