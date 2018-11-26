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
	<?php
	  try{
	    $db = new PDO('sqlite:./myDB/timber.db');
	    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    $stmt = $db->prepare('SELECT * FROM users');
	    $stmt->execute();
	    $result_set = $stmt->fetchAll();
      foreach ($result_set as $result){
        echo "user: <b>$result[username]</b> <br/>";
        $stmt = $db->prepare('SELECT treeID, name FROM trees WHERE username == ?');
        $stmt->execute(array($result['username']));
        $result_set = $stmt->fetchAll();
        if (count($result_set) == 0){
          echo "User has submitted no trees<br/>";
        }else {
          echo "Submitted trees:<br/>";
          foreach($result_set as $tuple) {
            echo "<a href= \"viewTree.php?treeID=$tuple[treeID]\">$tuple[name]</a><br/>";
          }
        }
        echo "</br>";
      }
	    $db = null;
	  } catch(PDOException $e) {
	    die('Exception : '.$e->getMessage());
	  }


	 ?>
</div>
</body>
</html>