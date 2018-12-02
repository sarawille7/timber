
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
  <h2>Species</h2>
  <b>Existing Species:</b><br>
   <?php

  try{ //accessing PossibleSpecies relation to populate dropdown
      $db = new PDO('sqlite:./myDB/timber.db');
      $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $possible_species = $db->query('SELECT species FROM PossibleSpecies;');
      foreach ($possible_species as $key => $value) {
        echo "$value[species]<br>";
      }
      $db = null;
    } catch(PDOException $e) {
      die('Exception : '.$e->getMessage());
    }

  ?>
  <br>
  <form action='createSpecies.php' method="post" enctype="multipart/form-data" id="speciesForm">
      Add New Species:<br><input type="text" name="species" required pattern="([A-Za-z]+\w)" minlength = "2" maxlength="60"><br>
    <input type="submit" value= 'Add' form="speciesForm">
</div>
</body>
</html>
