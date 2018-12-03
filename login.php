<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include("menu.PHP");

<div class = "main">
  <h2>Login</h2>
  try{
  <form action="loginProcess.php" method="post">
      Username:<br><input type="text" name="username" required pattern="[A-Z]\w+|[a-z]\w+"><br>
      Password:<br><input type="password" name="password"><br>
  <input type="submit" value= '<?php echo "Login"; ?>'>
  </form>
} catch(PDOException $e){
  error_reporting(E_ALL);
}
?>
  <p>Don't have an account? </p> <a href="user_form.php">Sign up here.</a>
</div>
</body>
</html>
