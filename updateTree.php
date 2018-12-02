<?php
    session_start();
	//path to the SQLite database file
        $db_file = './myDB/timber.db';

        if(empty($_POST["treeID"]) || empty($_POST["treename"]) || empty($_FILES["photo"]) || empty($_POST["rings"]) || empty($_POST["description"]) || empty($_POST["species"]) || empty($_POST["height"])) {
		$treeID = $_POST['treeID'];
		$name = $_POST['name'];
        //$photoID = $_POST['photoID'];
        $rings = $_POST['rings'];
        $description = $_POST['description'];
        $species = $_POST['species'];
        $height = $_POST['height'];
		//redirect back to input form using header()
		header("Location: /tree_form.php?treeID=".$treeID."&name=".$name."&rings=".$rings."&description=".$desription."&species=".$species."&height=".$height);
		die();
	} 
        //treeID username name photoID rings description species height

        try {
            $photo = crc32(uniqid());
            //$treename = $_POST["treename"];
            $dir = "images/";
            $file = $dir . $photo;//basename($_FILES["photo"]["name"]);
            // Check if it's an image file
            if(isset($_FILES["photo"])) {
                $check = getimagesize($_FILES["photo"]['tmp_name']);
                if($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".";
                    if (move_uploaded_file($_FILES["photo"]['tmp_name'], $file)) {
                        //echo "The file has been uploaded.";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                        die();
                    }
                    } else {
                    echo "File is not an image.";
                    die();
                }
            }
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //$stmt = $db->prepare('update trees(treeID, username, name, photoID, rings, descript, species, height) VALUES(?,?, ?, ?, ?, ?, ?, ?)');
            //$stmt->execute(array(crc32(uniqid()), $_SESSION["username"], $_POST["treename"],$photo, $_POST["rings"], $_POST["description"], $_POST["species"], $_POST["height"]));
	    $stmt = $db->prepare("update trees set username=?, name=?, photoID=?, rings=?, descript=?, species=?, height=? where treeID=?;");
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $name);
            $stmt->bindParam(3, $photoID);
            $stmt->bindParam(4, $rings);
            $stmt->bindParam(5, $description);
            $stmt->bindParam(6, $species);
            $stmt->bindParam(7, $height);
            $stmt->bindParam(8, $treeID);


	    $username = $_SESSION["username"];
	    $name = $_POST['treename'];
	    $photoID = $photo;
	    $rings = $_POST['rings'];
        $description = $_POST['description'];
        $species = $_POST['species'];
        $height = $_POST['height'];
        $treeID = $_POST['treeID'];
	    $stmt->execute();
            //echo "<font color='blue'>$ssn</font> $fname $mname $lname<br/>\n";

            //disconnect from db
            $db = null;
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }

	header("Location: /userProfile.php?success=true");

?>