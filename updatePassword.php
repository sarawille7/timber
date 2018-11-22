<?php
    
        if(empty($_POST["password"]) || empty($_POST["oldpassword"]) ||empty($_POST["username"])) {
            //redirect back to input form using header()
            header("Location: /password_form.php?username=".$username);
            die();
        }

        try {
            //open connection to the airport database file
            $hashed_password = password_hash ($_POST["password"] , PASSWORD_DEFAULT );
	        $db = new PDO('sqlite:./myDB/timber.db');

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            
            $stmt = $db->prepare('UPDATE users SET password=? WHERE username=?;');
            $stmt->execute(array($hashed_password,$_POST["username"]));

            $db = null;
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }

	header("Location: /userProfile.php?success=true");

?>
