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
<head>
	<link rel="stylesheet" type="text/css" href="basic.css">
</head>
<body>
<?php
include("menu.PHP");
?>

<div class = "main">
	<br>
	<?php
	  try{
	    $db = new PDO('sqlite:./myDB/timber.db');
	    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $stmt = $db->prepare('SELECT * FROM trees WHERE treeID == ?');
	    $stmt->execute(array($_GET["treeID"]));
	    $result = $stmt->fetch();
			echo "<h1>$result[name]</h1> </br></br></br></br></br>";
			echo "<img src=\"images/$result[photoID]\" alt=\"no image found at images/$result[photoID]\"></br>";
	    echo "<h3>description: $result[descript] </h3>";
	    echo "<h3>species: $result[species] </h3>";
	    echo "<h3>rings: $result[rings] </h3>";
	    echo "<h3>height: $result[height] </h3>";

	    $db = null;
	  } catch(PDOException $e) {
	    die('Exception : '.$e->getMessage());
	  }
		?>

</div>
</body>
</html>
