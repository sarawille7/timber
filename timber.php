<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="basic.css"></head>
<body>
  <?php
  include("menu.PHP");
  ?>

  <div class = "main">

    <?php

      if (!isset($_SESSION)){
          session_start();
        } 
      if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
        //user is not logged in
        echo "<h2>Welcome to Timber!</h2><a href=\"login.php\">Login</a></br><a href=\"user_form.php\">Sign Up</a>";
      }
      else {
        //redirect to user profile
        header("Location: userProfile.php");
      }

    ?>
  </div>


</body>
</head>
