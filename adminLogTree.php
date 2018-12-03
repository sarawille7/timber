
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
  <h2>Tree Log</h2>
   <?php

  try{ //accessing PossibleSpecies relation to populate dropdown
      $db = new PDO('sqlite:./myDB/timber.db');
      $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $logEntries = $db->query('SELECT * FROM TreeActivity;');
      foreach (array_reverse($logEntries->fetchAll()) as $tuple) {
        echo "<br><br>$tuple[event] on $tuple[treeID] at $tuple[eventTime]";
        if ($tuple['oldName'] != $tuple['newName']){
          if (!$tuple['oldName']){
            echo "<br>Name: NULL -> $tuple[newName]";
          } else {
            echo "<br>Name: $tuple[oldName] -> $tuple[newName]";
          }
        }
        if ($tuple['oldPhotoID'] != $tuple['newPhotoID']){
          if (!$tuple['oldPhotoID']){
            echo "<br>Photo: NULL -> $tuple[newPhotoID]";
          } else {
            echo "<br>Photo: $tuple[oldPhotoID] -> $tuple[newPhotoID]";
          }
        }
        if ($tuple['oldRings'] != $tuple['newRings']){
          if (!$tuple['oldRings']){
            echo "<br>Rings: NULL -> $tuple[newRings]";
          } else {
            echo "<br>Rings: $tuple[oldRings] -> $tuple[newRings]";
          }
        }
        if ($tuple['oldDescript'] != $tuple['newDescript']){
          if (!$tuple['oldDescript']){
            echo "<br>Descript: NULL -> $tuple[newDescript]";
          } else {
            echo "<br>Descript: $tuple[oldDescript] -> $tuple[newDescript]";
          }
        }
        if ($tuple['oldSpecies'] != $tuple['newSpecies']){
          if (!$tuple['oldSpecies']){
            echo "<br>Name: NULL -> $tuple[newSpecies]";
          } else {
            echo "<br>Name: $tuple[oldSpecies] -> $tuple[newSpecies]";
          }
        }
        if ($tuple['oldHeight'] != $tuple['newHeight']){
          if (!$tuple['oldHeight']){
            echo "<br>Height: NULL -> $tuple[newHeight]";
          } else {
            echo "<br>Height: $tuple[oldHeight] -> $tuple[newHeight]";
          }
        }
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
