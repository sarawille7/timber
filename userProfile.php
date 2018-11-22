<?php
session_start();
if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
	//user is not logged in
	header("Location: login.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>

<p><?php echo "You are logged in as "; echo $_SESSION["username"]; ?>.</p>
<?php 
//echo "<a href=\"./passenger_form.php?ssn=$tuple[ssn]\">Update</a><br/>\n";
echo "<a href=\"./password_form.php?username=$_SESSION[username]\">Update Password</a><br/>\n"; ?>
<!-- <p><a href="password_form.php?username=$_SESSION['username']">Update Password</a></p> -->
<p><a href="logout.php">Logout</a></p>
<?php

try{
  $db = new PDO('sqlite:./myDB/timber.db');
  $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $db->prepare('SELECT treeID, name FROM trees WHERE username == ?');
  $stmt->execute(array($_SESSION["username"]));
  $result_set = $stmt->fetchAll();
  if (count($result_set) == 0){
    echo "You have submitted no trees.\n <a href=\"createTree.php\">Submit a tree now.<a>";
  }else {
    echo "<b>Submitted trees:</b><br/>";
    foreach($result_set as $tuple) {
      echo "<a href= \"viewTree.php?treeID=$tuple[treeID]\">$tuple[name]</a><br/>";
    }
    echo "<br/><a href=\"tree_form.php\">Submit another tree.<a>";
  }
  $db = null;
} catch(PDOException $e) {
  die('Exception : '.$e->getMessage());
}
  
?>

</body>
</html>