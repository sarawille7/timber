<?php
session_start();
if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
	//user is not logged in
	//header("Location: login.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>

<p><?php echo "You are logged in as "; echo $_SESSION["username"]; ?>.</p>
<p><a href="updateUser.php">Update</a></p>
<p><a href="logout.php">Logout</a></p>

</body>
</html>