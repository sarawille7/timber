<?php
	//path to the SQLite database file
        $db_file = './myDB/airport.db';

	if(empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["ssn"]) || empty($_POST["oldssn"])) {
		$fname = $_POST['firstname'];
		$lname = $_POST['lastname'];
		$ssn = $_POST['ssn'];
		//redirect back to input form using header()
		header("Location: http://54.173.137.240/~ubuntu/passenger_form.html?firstname=".$fname."&lastname=".$lname."&ssn=".$ssn);
		die();
	} 


        try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	    $stmt = $db->prepare("update passengers set f_name=?, m_name=?, l_name=?, ssn=? where ssn=?;");
            $stmt->bindParam(1, $fname);
            $stmt->bindParam(2, $mname);
            $stmt->bindParam(3, $lname);
            $stmt->bindParam(4, $ssn);
	    $stmt->bindParam(5, $oldssn);


	    $fname = $_POST['firstname'];
	    $mname = $_POST['middleinitial'];
	    $lname = $_POST['lastname'];
	    $ssn = $_POST['ssn'];
	    $oldssn = $_POST['oldssn'];
	    $stmt->execute();
            //echo "<font color='blue'>$ssn</font> $fname $mname $lname<br/>\n";

            //disconnect from db
            $db = null;
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }

	header("Location: http://54.173.137.240/~ubuntu/showPassengers.php?success=true");

?>
