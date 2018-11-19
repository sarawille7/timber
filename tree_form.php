
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>

<h2>Create Tree</h2>

 <?php
 //treeID
 //username
 //name
 //photoID
 //rings
 //description
 //species
 //height
$is_update = true;

if(isset($_GET['treename'])){
    $treename = $_GET['treename'];}
else{
    $treename = '';
    $is_update = false;}


if(isset($_GET['photo'])){
    $photo = $_GET['photo'];}
else{
    $photo = '';
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
    $action_direct = 'updateTree.php';
    $button = 'Update Info';}
else{
    $action_direct = 'createTree.php';
    $button = 'Submit';}
?>

<form action='<?php echo $action_direct ?>' method="post">
    Tree Name:<br><input type="text" name="treename" required pattern="[A-Z]\w+|[a-z]\w+" value='<?php echo $treename; ?>'><br>
    Photo:<br><input type="file" name="photo" accept="image/*" value='<?php echo $photo; ?>'><br>
    Number of Rings:<br><input type="text" name="rings" required pattern="[0-9]+" value='<?php echo $rings; ?>'><br>
    Description:<br><input type="text" name="description" value='<?php echo $description; ?>'><br><br>
    Species:<br><input type="text" name="species" required pattern="[A-Z]\w+|[a-z]\w+" value='<?php echo $species; ?>'><br><br>
    Height in Inches:<br><input type="text" name="height" required pattern="[0-9]+" value='<?php echo $height; ?>'><br><br>
<input type="submit" value= '<?php echo $button; ?>'>
</form>

</body>
</html>
