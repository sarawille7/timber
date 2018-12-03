<html>
  <head>
    <link rel="stylesheet" type="text/css" href="basic.css">
    <style>

      .buttonsContainer{
        width: 100%;
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
      .matcher{
        display: inline-block;
      }

      .likeButton {
        background-color: #0ffa90;
        color: #164c17;
        float:left;
        border:0px;
      }
      .passButton {
        background-color: #993010;
        color: #421401;
        float:right;
      }

      .matchTitle{
        padding-top: 30px;
        font-family: "Trebuchet MS", Helvetica, sans-serif;
        color: #293a20;
        margin-left: 300px;
        font-weight: bold;
        font-size: 3em;
      }

      .matchTagline{
        margin-left: 350px;
        font-family: sans-serif;
        color: #405137;
        font-size: 1em;
        font-weight: bold;
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
        include("checkBan.php");

        //that way we don't query db every loop
        // query random ID
        $currentUser = $_SESSION["username"];
        $stmt = $db->prepare('SELECT * FROM Trees WHERE treeID NOT IN (SELECT treeID FROM Matches WHERE Matches.username == ?) AND (Trees.username <> ?)
          AND (Trees.username NOT IN (SELECT username FROM Banned WHERE Banned.banDate > date(\'now\')))'); //find all matches from user
        $stmt->execute(array($currentUser, $currentUser));
        $nonMatchesSelect = $stmt->fetchAll();
        if(!$nonMatchesSelect){
          header("Location: noTrees.php");
        }
        $selectedTreeKey = array_rand($nonMatchesSelect, 1);
        $selectedTree = $nonMatchesSelect[$selectedTreeKey];
        $treeImgWidth = getimagesize($selectedTree["photoID"])[0];

        $db = null;
    ?>


    <div class = "main">

      <!-- Title content -->
      <div class = "matchTitle">
          Find Your Match!
      </div>
      <div class = "matchTagline">
          Hit "LIKE!" to add the Tree to your matches! Hit "PASS!" to see more Trees!
      </div>

      <!-- Image and other Profile content -->
      <table class="treeProfile">
        <tr>
          <td>
            <div class="img-container-background">
                <div class="img-container">

                  <?php echo "<img src=\"images/$selectedTree[photoID]\" alt=\"no image found at images/$selectedTree[photoID]\" class=\"treeImg\" style=\"max-width: $treeImgWidth\"></br>"; ?>

                </div>
            </div>
          </td>
        <tr>
          <td>
            <div class="treeProfileText ">
  				    <?php echo '<h3>'.$selectedTree["name"].'</h3>'?>
  				    Species: <?php echo $selectedTree["species"]?> <br/>
  				    Rings: <?php echo $selectedTree["rings"]?> <br/>
  				    Height: <?php echo $selectedTree["height"]?> inches <br/>
  				    <div class="desc"> <?php echo $selectedTree["descript"]?> </div> <br/>
            </div>
          </td>
        </tr>
      </table>

    <!-- Buttons -->
          <table class="buttonsContainer">
            <tr>
              <td>
            <a class = "button passButton" href = "findMatches.php"><h3>PASS!</h3></a>
          </td>
          <td>
            <?php
            //Now, populate a hidden form with all of these values. If the user chooses "LIKE!", the form is sent.
            echo '<div class="matcher">
                    <form method="post" action="createMatch.php">
                      <input type="hidden" name="username" value="'.$currentUser.'">
                      <input type="hidden" name="treeID" value="'.$selectedTree["treeID"].'">
                      <button type="submit" name="submit_param" value="submit_value" class="button likeButton">
                        <h3>LIKE!</h3>
                      </button>
                    </form>
                  </div>';
             ?>
           </td>
         </tr>
       </table>
    </div>


    <?php
    } catch(PDOException $e) {
      die('Exception : '.$e->getMessage());
    }
    ?>
  </body>
</html>
