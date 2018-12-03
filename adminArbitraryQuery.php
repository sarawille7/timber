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
<h2>WRITE ANY QUERY</h2>

<form action="executeArbitraryQuery.php" method="post">
  Query:<br><input size="50" value="<?php if(isset($_GET['query'])){echo $_GET['query'];} ?>" type="text" name="query"><br>
  <input type="submit">
</form>


<?php if(isset($_GET['out'])){
echo "<br/><b>Result:</b><br/>";
echo $_GET['out'];
} ?>

</body>
</html>
