<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="basic.css">
  </head>
  <body>
    <div class="navbar">
      <h3 class='logo'> TIMBER </h3>
      <a href="timber.php">Home</a>
      <?php
        if (!isset($_SESSION)){
          session_start();
        } 
        if (!isset($_SESSION['privileges'])) {
          echo "<a href=\"login.php\">Login</a> ";
        } 
        else if ($_SESSION['privileges'] == "admin"){
          echo "<a href=\"admin.php\">Admin Interface</a>"; 
        } else {
          echo "<a href=\"userProfile.php\">My Profile</a>"; 
        }
        ?>
      <a href="index.php">CS455 Dir</a>
    </div>
  </body>

</html>
