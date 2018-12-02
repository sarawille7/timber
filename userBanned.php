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
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>
<?php
include("menu.PHP");
?>

<div class = "main">
	<h1><?php  echo $_SESSION["username"]; ?>'s profile</h1><br>
	<?php
	//echo "<a href=\"./passenger_form.php?ssn=$tuple[ssn]\">Update</a><br/>\n";
	echo "<a class='option'  href=\"./password_form.php?username=$_SESSION[username]\">Update Password</a>\n"; ?>
	<a class='option' href="logout.php">Logout</a>
	<?php

	try{
	  $db = new PDO('sqlite:./myDB/timber.db');
	  $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare('SELECT banDate FROM banned WHERE username == ?');
    $stmt->execute(array($_SESSION['username']));
    $result_set = $stmt->fetchAll();
    if (count($result_set) != 0){
      $ban = "";
      foreach($result_set as $tuple) {
        if ($tuple['banDate'] > $ban){
          $ban = $tuple['banDate'];
        }
      }
      $currentTime = new DateTime("NOW");
      $now = $currentTime->format('Y-m-d H:i:s');
      if ($ban > $now){
        echo "<br><br><h2>You've been banned! Your ban ends on $ban.</h2>";
        die();
      }
    }
	} catch(PDOException $e) {
	  die('Exception : '.$e->getMessage());
	}

	?>
</div>
</body>
</html>
