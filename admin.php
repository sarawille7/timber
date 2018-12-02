<?php
session_start();
if(empty($_SESSION["username"]) || empty($_SESSION["valid"]) || $_SESSION["privileges"] != "admin") {
	//user is not an admin
	header("Location: timber.php");
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
	<p><?php echo "If you can see this, you are an administrative user, "; echo $_SESSION["username"]; ?>.</p>
  <a href = "adminViewTrees.php">View all trees</a>
  <a href = "adminViewUsers.php">View all users</a>
  <br><a href = "adminSpecies.php">Manage species</a>
	<p><a href="logout.php">Logout</a></p>
	<?php

	?>
</div>
</body>
</html>
