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
        if ($result['privileges'] == "admin"){
          echo "Is an admin.<br/><br/>";
        }
        else {
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
          $stmt = $db->prepare('SELECT banDate FROM banned WHERE username == ?');
          $stmt->execute(array($result['username']));
          $result_set = $stmt->fetchAll();
          if (count($result_set) == 0){
            echo "User has never been banned. Ban for: 
              <a  href= \"createBan.php?username=$result[username]&banType=day\">1 Day?</a>  
              <a  href= \"createBan.php?username=$result[username]&banType=week\">1 Week?</a>  
              <a  href= \"createBan.php?username=$result[username]&banType=month\">1 Month?</a>  
              <a  href= \"createBan.php?username=$result[username]&banType=year\">1 Year?</a>  
              <a  href= \"createBan.php?username=$result[username]&banType=lifetime\">1000 Years?</a>
              <br/>";
          }else {
            $ban = "";
            foreach($result_set as $tuple) {
              if ($tuple['banDate'] > $ban){
                $ban = $tuple['banDate'];
              }
            }
            $currentTime = new DateTime("NOW");
            $now = $currentTime->format('Y-m-d H:i:s');
            if ($ban > $now){
              echo "User is banned until: $ban. <a  href= \"unban.php?username=$result[username]\">Unban?</a><br/>";
            } else {
              echo "User's ban ended on: $ban. Ban for: 
              <a  href= \"createBan.php?username=$result[username]&banType=day\">1 Day?</a>  
              <a  href= \"createBan.php?username=$result[username]&banType=week\">1 Week?</a>  
              <a  href= \"createBan.php?username=$result[username]&banType=month\">1 Month?</a>  
              <a  href= \"createBan.php?username=$result[username]&banType=year\">1 Year?</a>  
              <a  href= \"createBan.php?username=$result[username]&banType=lifetime\">1000 Years?</a>
              <br/>";
            }
          }
          echo "<br/>";
        }
      }
	    $db = null;
	  } catch(PDOException $e) {
	    die('Exception : '.$e->getMessage());
	  }


	 ?>
</div>
</body>
</html>