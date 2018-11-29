<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>
<?php
if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
  //user is not logged in
  header("Location: login.php");
  die();
}
include("menu.PHP");
?>
<div class = "main">
  <h2>No More Trees to Match With! :(</h2>
  <a href="tree_form.php">Why not make some more?</a>

</div>
</body>
</html>
