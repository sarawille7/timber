<?php
session_start();
if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
	//user is not logged in
	header("Location: login.php");
	die();
}
if($_SESSION["privileges"] == "admin") {
	//user is admin and shouldn't use this page
	header("Location: admin.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="basic.css">
	<style>
	.userTitle{
		padding-top: 30px;
		font-family: "Trebuchet MS", Helvetica, sans-serif;
		color: #293a20;
		font-weight: bold;
		font-size: 2em;
	}
	</style>
</head>
<body>
<?php
include("menu.PHP");
?>

<div class = "main">
	<div class = "userTitle"><?php  echo $_SESSION["username"]; ?>'s profile</div><br>
	<?php
	//echo "<a href=\"./passenger_form.php?ssn=$tuple[ssn]\">Update</a><br/>\n";
	echo "<a class='option'  href=\"./password_form.php?username=$_SESSION[username]\">Update Password</a>\n"; ?>
	<a class='option' href="logout.php">Logout</a>
	<?php

	try{
	  $db = new PDO('sqlite:./myDB/timber.db');
	  $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    include("checkBan.php");
	  $stmt = $db->prepare('SELECT treeID, name FROM trees WHERE username == ?');
	  $stmt->execute(array($_SESSION["username"]));
		$result_set = $stmt->fetchAll();
	  if (count($result_set) == 0){
	    echo "<br><br><br><br><a class=option href=\"createTree.php\">Submit a tree<a>";
	  }else {
			echo "<h2>Submitted trees:</h2>";
	    foreach($result_set as $tuple) {
	      echo "<a class='tree' href= \"viewTree.php?treeID=$tuple[treeID]\">$tuple[name]</a>";
	    }
	    echo "<br><br><p><a class='option' href=\"tree_form.php\">Submit another tree.</a></p>";
	  }
    //Matches
    $stmt = $db->prepare('SELECT treeID, name FROM (select treeID, name from trees) NATURAL JOIN matches NATURAL JOIN users WHERE username == ?');
	  $stmt->execute(array($_SESSION["username"]));
	  $result_set = $stmt->fetchAll();
    echo "<span>";
	  if (count($result_set) == 0){
	    echo "<br><br><br><a class=option href=\"findMatches.php\">Get matched!<a>";
	  }else {
			echo "<br/><h2>Matches:</h2>";
	    foreach($result_set as $tuple) {
	      echo "<a class='tree' href= \"viewTree.php?treeID=$tuple[treeID]\">$tuple[name]</a>";
	    }
	    echo "<br><br><p><a class='option' href=\"findMatches.php\">Continue matching!</a></p>";
	  }
    echo "</span>";
	  $db = null;
	} catch(PDOException $e) {
	  die('Exception : '.$e->getMessage());
	}

	?>
</div>
</body>
</html>
