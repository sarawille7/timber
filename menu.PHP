<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css">
    <style>
      body {margin:0;
      top:30px;}

      .navbar {
        overflow: hidden;
        background-color: #293a20;
        position: fixed;
        top: 0;
        width: 100%;
      }

      .navbar a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        font-family: "Arial", "Helvetica", sans-serif;
      }

      .navbar a:hover {
        color: #00a774;
      }

      .main {
        padding: 16px;
        margin-top: 30px;
        height: 1500px; /* Used in this example to enable scrolling */
      }
    </style>
  </head>
  <body>
    <div class="navbar">
      <!-- <a href="timber.php">Home</a> -->
      <?php
        if (!isset($_SESSION)){
          session_start();
        }
        if (!isset($_SESSION['privileges'])) {
          echo "<a href=\"login.php\">Login</a> ";
          echo "<a href=\"user_form.php\">Sign Up</a> ";
        }
        else if ($_SESSION['privileges'] == "admin"){
          echo "<a href=\"admin.php\">Admin Interface</a>";
        } else {
          echo "<a href=\"userProfile.php\">My Profile</a>";
          echo "<a href=\"findMatches.php\">Find Matches</a>";
        }
        ?>
      <a href="index.php">CS455 Dir</a>
    </div>
  </body>

</html>
