<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css">
</head>
<body>


 <?php
    $action_direct = 'createUser.php';
    $button = 'Submit';

// INCLUDE THE FOLLOWING LINE ON EVERY PAGE TO ADD THE MENU
    include("menu.PHP");
?>
<div class = "main">
  <h2>Create User</h2>
  <form action='<?php echo $action_direct ?>' method="post">
      Username:<br><input type="text" name="username" required pattern="[A-Z]\w+|[a-z]\w+"><br>
      Password:<br><input type="password" name="password" required><br>
  <input type="submit" value= '<?php echo $button; ?>'>
  </form>
</div>
</body>
</html>
