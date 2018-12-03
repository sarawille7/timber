<?php
        session_start();
        if(empty($_SESSION["username"]) || empty($_SESSION["privileges"]) || empty($_GET["treeID"])) {
            //something is wrong...
            header("Location: userProfile.php");
            die();
        }

        try {
            //open connection to the airport database file
            $hashed_password = password_hash ($_POST["password"] , PASSWORD_DEFAULT );
            $db = new PDO('sqlite:./myDB/timber.db');

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //verify
            if ($_SESSION["privileges"] != "admin"){
              $stmt = $db->prepare('SELECT * FROM trees WHERE treeID == ?');
              $stmt->execute(array($_GET["treeID"]));
              $result = $stmt->fetch();
              if ($result["username"] != $_SESSION["username"]){
                header("Location: userProfile.php");
                die();
              }
            }
            

            $stmt = $db->prepare('DELETE FROM trees WHERE treeID == ?;');
            $stmt->execute(array($_GET["treeID"]));

            $db = null;
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }

  if ($_SESSION["privileges"] == "admin"){
    header("Location: adminViewTrees.php");
  } else {
    header("Location: userProfile.php?success=true");
  }
	

?>
