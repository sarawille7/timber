<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="basic.css">
    <style>
      body {margin:0;
      top:30px;}

      .navbar {
        overflow: hidden;
        background-color: #269;
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
        background: #a2f2f2;
        color: black;
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
      <a href="timber.php">Home</a>
      <a href="userProfile.php">My Profile</a>
      <a href="index.php">CS455 Dir</a>
    </div>
  </body>

</html>
