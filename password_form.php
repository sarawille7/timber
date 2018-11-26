<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css">
</head>
<body>

 <?php
if(isset($_GET['username'])){
    $username = $_GET['username'];
}else{
         $username = '';
}
$action_direct = 'updatePassword.php';
$button = 'Update Password';

// INCLUDE THE FOLLOWING LINE ON EVERY PAGE TO ADD THE MENU
    include("menu.PHP");
?>
<div class = "main">
  <h2>Update Password</h2>
  <form action='<?php echo $action_direct ?>' method="post">
      Old Password:<br><input type="password" name="oldpassword"><br>
      New Password:<br><input type="password" name="password"><br>
      <?php
      echo "<input type='hidden' name='username' value=$username>";
      ?>
  <input type="submit" value= '<?php echo $button; ?>'>

  </form>
</div>
</body>
</html>
