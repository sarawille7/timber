<?php
	//path to the SQLite database file

        if(empty($_POST["username"]) || empty($_POST["password"])) {
            //redirect back to input form using header()
            header("Location: http://54.173.137.240/~ubuntu/user_form.php");
            die();
        } 


        try {
            //open connection to the airport database file
            $hashed_password = password_hash ( $password , PASSWORD_DEFAULT );
	        $db = new PDO('sqlite:./myDB/timber.db');

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	        $stmt = $db->prepare("update passengers set user=?, pass=?;");
            $stmt->bindParam(1, $user);
            $stmt->bindParam(2, $pass);

	        $user = $_POST['username'];
	        $pass = $hashed_password;
	        $stmt->execute();

            $db = null;
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }

	header("Location: http://54.173.137.240/~ubuntu/showLogin.php?success=true");

?>
