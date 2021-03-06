<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>
<?php
if(empty($_SESSION["username"])) {
  //user is not logged in
  header("Location: login.php");
  die();
}
if($_SESSION["privileges"] == "admin") {
	//user is admin and shouldn't use this page
	header("Location: admin.php");
	die();
}
include("menu.PHP");
?>
<div class = "main">
  

   <?php

  $is_update = true;

  if(isset($_GET['treeID'])){
    $treeID = $_GET['treeID'];}
  else{
    $treeID = '';
    $is_update = false;}

  if(isset($_GET['treename'])){
      $treename = $_GET['treename'];}
  else{
      $treename = '';
      $is_update = false;}


  if(isset($_GET['rings'])){
      $rings = $_GET['rings'];}
  else{
      $rings = '';
      $is_update = false;}

  if(isset($_GET['description'])){
      $description = $_GET['description'];}
  else{
      $description = '';
      $is_update = false;}

  if(isset($_GET['species'])){
      $species = $_GET['species'];}
  else{
      $species = '';
      $is_update = false;}

  if(isset($_GET['height'])){
      $height = $_GET['height'];}
  else{
      $height = '';
      $is_update = false;}


  if($is_update === true){
      ?><h2>Update Tree</h2><?php
      $action_direct = 'updateTree.php';
      $button = 'Update Info';}
  else{
      ?><h2>Create Tree</h2><?php
      $action_direct = 'createTree.php';
      $button = 'Submit';}

  try{ //accessing PossibleSpecies relation to populate dropdown
      $db = new PDO('sqlite:./myDB/timber.db');
      $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      include("checkBan.php");
      $possible_species = $db->query('SELECT species FROM PossibleSpecies;');
      $db = null;
    } catch(PDOException $e) {
      die('Exception : '.$e->getMessage());
    }

  ?>
<!-- TODO: input name "description" should be styled as a larger entry box to allow users to read all their content more easily -->
  <form action='<?php echo $action_direct ?>' method="post" enctype="multipart/form-data" id="treeForm">
      Tree Name:<br><input type="text" name="treename" required pattern="([A-Za-z]+\w)" minlength = "2" maxlength="60" value='<?php echo $treename; ?>'><br>
      Photo:<br><input type="file" name="photo" id="photo" accept="image/*" required><br>
      Number of Rings:<br><input type="text" name="rings" required pattern="[0-9]+" value='<?php echo $rings; ?>'><br>
      Species:<br><select name="species" required value='<?php echo $species; ?>'>
                  <?php
                    foreach ($possible_species as $key => $value) {
                      echo '<option value=' . $value['species'] . '>' . $value['species'] . '</option>';
                    }
                  ?>
                  </select>
        <br>
      Height in Inches:<br><input type="text" name="height" required pattern="[0-9]+" value='<?php echo intval($height); ?>'><br>
      
  
        Description (280 Characters Max):<br><textarea name="description" maxlength = "280" required><?php echo $description;  ?></textarea><br>
        <?php
      echo "<input type='hidden' name='treeID' value=$treeID>";
      ?>
    <input type="submit" value= '<?php echo $button; ?>' form="treeForm">
    </form>
</div>
</body>
</html>
