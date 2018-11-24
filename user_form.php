<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css">
</head>
<body>


 <?php
//$is_update = true;

// if(isset($_GET['username'])){
//     $username = $_GET['username'];}
// else{
//     $username = '';
//     $is_update = false;}

// if(isset($_GET['password'])){
//     $password = $_GET['password'];}
// else{
//     $password = '';
//     $is_update = false;}


// if($is_update === true){
//     $action_direct = 'updateUser.php';
//     $button = 'Update Info';}
//else{
    $action_direct = 'createUser.php';
    $button = 'Submit';
//}

// INCLUDE THE FOLLOWING LINE ON EVERY PAGE TO ADD THE MENU
    include("menu.PHP");
?>
<div class = "main">
  <h2>Create User</h2>
  <form action='<?php echo $action_direct ?>' method="post">
      Username:<br><input type="text" name="username" required pattern="[A-Z]\w+|[a-z]\w+" value='<?php echo $username; ?>'><br>
      Password:<br><input type="password" name="password" value='<?php echo $password; ?>'><br>
  <input type="submit" value= '<?php echo $button; ?>'>
  </form>
</div>
</body>
</html>
