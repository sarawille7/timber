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
	<style>
		*{
			box-sizing: border-box;
		}
			/* Create two equal columns that floats next to each other */
		.col {
		float: left; /*TODO: probably need to fix*/
		width: 40%; /* was 50 in example */
		padding: 10px;
		height: 300px; /* Should be removed. Only for demonstration */
		}

		/* Clear floats after the columns */
		.row:after {
		content: "";
		display: table;
		clear: both;
		}
	</style>
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
