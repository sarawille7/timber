<?php
session_start();
if(empty($_GET["treeID"])) {
	//error
	header("Location: timber.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>

<?php
  $treeID = $_GET["treeID"];
  echo "You are viewing tree #$treeID."


 ?>

</body>
</html>