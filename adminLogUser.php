
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>
<?php
session_start();
if(empty($_SESSION["username"])) {
  //user is not logged in
  header("Location: login.php");
  die();
}
if($_SESSION["privileges"] != "admin") {
	//user is not admin and shouldn't use this page
	header("Location: admin.php");
	die();
}
include("menu.PHP");
?>
<div class = "main">
  <h2>User Log</h2>
   <?php

  try{ //accessing PossibleSpecies relation to populate dropdown
      $db = new PDO('sqlite:./myDB/timber.db');
      $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $logEntries = $db->query('SELECT * FROM UserActivity;');
      foreach (array_reverse($logEntries->fetchAll()) as $tuple) {
        echo "<br><br>$tuple[event] on $tuple[username] at $tuple[eventTime]";
        if ($tuple['oldPassword'] != $tuple['newPassword']){
          echo "<br>Password changed";
        }
        if ($tuple['oldPrivileges'] != $tuple['newPrivileges']){
          if (!$tuple['oldPrivileges']){
            echo "<br>Privileges: NULL -> $tuple[newPrivileges]";
          } else {
            echo "<br>Privileges: $tuple[oldPrivileges] -> $tuple[newPrivileges]";
          }
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
