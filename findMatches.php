<html>
  <head>
    <link rel="stylesheet" type="text/css" href="basic.css">
    <style>

      .buttonsContainer{
        margin: auto;
        /* width: 10%; */
      }

      .button {
          padding: 16px 16px;
          border-radius: 20px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 28px;
          font-family: "Lucida Console", monospace;
          margin: 2px 2px;
          -webkit-transition-duration: 0.4s; /* Safari */
          transition-duration: 0.4s;
          cursor: pointer;
      }
      .button:hover{
        box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
        color: #fff;
      }

      .likeButton {
        background-color: #0ffa90;
        color: #164c17;
        border-bottom-color: #164c17;
        float:left;
      }
      .passButton {
        background-color: #993010;
        color: #421401;
        border-bottom-color: #421401;
        float:right;
      }

      .matchTitle{
        font-family: sans-serif;
        color: #333;
        margin-left: 300px;
      }

      .matchTagline{
        margin-left: 350px;
        font-family: sans-serif;
        color: #333;
      }

      *{
  			box-sizing: border-box;
  		}

            /* Create two equal columns that floats next to each other */
      .col {
          width: 50%; /* was 50 in example */
          padding: 10px;
          height: 300px; /* Should be removed. Only for demonstration */
          float: left;
      }


      /* Clear floats after the columns */
      .row:after {
          content: "";
          display: table;
          clear: both;
      }

      .row{
        margin-left: 25%;
      }


    </style>
  </head>

  <body>
    <?php
    session_start();
    if(empty($_SESSION["username"]) || empty($_SESSION["valid"])) {
    	//user is not logged in
    	header("Location: login.php");
    	die();
    }
    if($_SESSION["privileges"] == "admin") {
    	//user is admin and shouldn't use this page
    	header("Location: admin.php");
    	die();
    }
    include("menu.PHP");
    ?>

    <!-- Obtaining Match -->
    <?php
      try{
        // access DB
        $db = new PDO('sqlite:./myDB/timber.db');
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //TODO: see if querying a query is possible, and then make non-matches selection a query result
        //that way we don't query db every loop
        // query random ID
        $currentUser = $_SESSION["username"];
        // $matchesOfUser = "SELECT treeID FROM Matches WHERE username == $_SESSION["username"]"; //find all matches from user
        $stmt = $db->prepare('SELECT * FROM Trees WHERE treeID NOT IN (SELECT treeID FROM Matches WHERE Matches.username == ?) AND (Trees.username <> ?)'); //find all matches from user
        $stmt->execute(array($currentUser));
        $nonMatchesSelect = $stmt->fetch();

        $selectedTreeKey = array_rand($nonMatchesSelect, 1);
        var_dump($nonMatchesSelect);
        $selectedTree = $nonMatchesSelect[$selectedTreeKey];
        var_dump($selectedTree);
        $db = null;
        } catch(PDOException $e) {
           die('Exception : '.$e->getMessage());
        }
    ?>



    <div class = "main">

      <!-- Title content -->
      <div class = "matchTitle">
        <h1>
          Find Your Match!
        </h1>
      </div>
      <div class = "matchTagline">
        <h4>
          Hit "LIKE!" to add the Tree to your matches! Hit "PASS!" to see more Trees!
        </h4>
      </div>

      <!-- Two Columns, Image and profile content -->
      <div class="row">
        <div class="col leftcol columnImage">
          <h1> test for image content </h1>
        </div>
        <div class="col rightcol columnText">
          <h1> test for text content </h1>
        </div>
      </div>

    <!-- Buttons -->
      <div class = "row">
        <div class = "buttonsContainer">
          <div class ="col">
            <a class = "button passButton" href = "findMatches.php"><h3>PASS!</h3></a>
          </div>
          <div class ="col">
            <a class = "button likeButton" href = ""><h3>LIKE!</h3></a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
