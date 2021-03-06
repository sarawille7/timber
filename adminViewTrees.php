<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
	<?php
	  try{
	    $db = new PDO('sqlite:./myDB/timber.db');
	    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $stmt = $db->prepare('SELECT * FROM trees');
	    $stmt->execute();
	    $result_set = $stmt->fetchAll();
      foreach ($result_set as $result){
        echo "name: <a href=\"viewTree.php?treeID=$result[treeID]\">$result[name]</a> <br/>";
        echo "species: $result[species] <br/>";
        echo "published by: $result[username] -- <a href=\"deleteTree.php?treeID=$result[treeID]\">Delete Tree?</a> <br/><br/>";
      }
	    $db = null;
	  } catch(PDOException $e) {
			error_reporting(E_ALL);
	    die('Exception : '.$e->getMessage());
	  }


	 ?>
</div>
</body>
</html>
