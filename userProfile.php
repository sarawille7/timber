<?php
session_start();
if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
	//user is not logged in
	header("Location: login.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>

<p><?php echo "You are logged in as "; echo $_SESSION["username"]; ?>.</p>
<p><a href="updatePassword.php">Update</a></p>
<p><a href="logout.php">Logout</a></p>
<?php
try{
    $db = new PDO('sqlite:./myDB/timber.db');
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare('SELECT treeID, name FROM trees WHERE username == ?');
    $stmt->execute(array($_SESSION["username"]));
    $result_set = $stmt->fetchAll();
    if (count($result_set) == 0){
      echo "You have submitted no trees. <a href=\"createTree.php\">Submit a tree now.<a>";
    }else {
      foreach($result_set as $tuple) {
        echo "<a href= \"viewTree?treeID=$tuple[treeID]\">$tuple[name]</a>";
      }
      echo "<a href=\"createTree.php\">Submit another tree.<a>";
    }
    $db = null;
  } catch(PDOException $e) {
    die('Exception : '.$e->getMessage());
  }
  
?>

</body>
</html>