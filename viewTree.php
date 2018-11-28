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
	?>


			<br/>
			<div class = "row">
				<div class = "col">
					<div class="treeProfileContent">
				    <div size="20"> <?php echo $result[name]?> </div>
				    Species: <?php echo $result[species]?> <br/>
				    Rings: <?php echo $result[rings]?> <br/>
				    Height: <?php echo $result[height]?> inches <br/>
				    <p> <?php echo $result[descript]?> </p> <br/>
					</div>
				</div>

				<div class = "col">
					<div class="img-container-background">
		          <div class="img-container">
		            <img src="images/<?php echo$result[photoID]?>" alt="No image found at images/<?php echo$result[photoID]?>" class="treeImg">
		          </div>
		      </div>
				</div>
			</div>

	  <?php  $db = null;
	  } catch(PDOException $e) {
	    die('Exception : '.$e->getMessage());
	  }
		?>


</div>
</body>
</html>
