<?php
session_start();
if(!isset($_GET["treeID"])) {
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
include("menu.PHP");
?>

<div class = "main">
	<?php
	  try{
	    $db = new PDO('sqlite:./myDB/timber.db');
	    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $stmt = $db->prepare('SELECT * FROM trees WHERE treeID == ?');
	    $stmt->execute(array($_GET["treeID"]));
	    $result = $stmt->fetch();
	    echo "name: $result[name] <br/>";
	    echo "description: $result[descript] <br/>";
	    echo "species: $result[species] <br/>";
	    echo "rings: $result[rings] <br/>";
	    echo "height: $result[height] <br/>";
      echo "<img src=\"images/$result[photoID]\" alt=\"no image found at images/$result[photoID]\">";
	    $db = null;
	  } catch(PDOException $e) {
	    die('Exception : '.$e->getMessage());
	  }


	 ?>
</div>
</body>
</html>
