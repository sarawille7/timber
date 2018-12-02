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
?>
      <table class="treeProfile">
        <tr>
          <td>
            <div class="img-container-background">
                <div class="img-container">
                  <?php echo "<img src=\"images/$result[photoID]\" alt=\"no image found at images/$result[photoID]\" class=\"treeImg\"></br>"; ?>
                </div>
            </div>
          </td>
        <tr>
          <td>
            <div class="treeProfileText ">
  				    <?php echo '<h3>'.$result["name"].'</h3>'?>
  				    Species: <?php echo $result["species"]?> <br/>
  				    Rings: <?php echo $result["rings"]?> <br/>
  				    Height: <?php echo $result["height"]?> inches <br/>
  				    <div class="desc"> <?php echo $result["descript"]?> </div> <br/>
            </div>
          </td>
        </tr>
        <?php 
          if ($result["username"] == $_SESSION["username"]){
            echo "<tr><td><div><a href = \"deleteTree.php?treeID=$result[treeID]\">Delete Tree?</a></div></td></tr>";
          }
        ?>
      </table>
<?php
    
	  $db = null;
	  } catch(PDOException $e) {
	    die('Exception : '.$e->getMessage());
	  }
		?>

</div>
</body>
</html>
