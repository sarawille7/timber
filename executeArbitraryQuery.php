<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if(empty($_SESSION["username"])) {
  //user is not logged in
  header("Location: login.php");
  die();
}
if($_SESSION["privileges"] != "admin") {
	//user is not admin and shouldn't use this page
	header("Location: admin.php");
	die();
}
	//path to the SQLite database file
        $db_file = './myDB/airport.db';

	if(!isset($_POST["query"])) {
		//redirect back to input form using header()
		header("Location: http://54.173.137.240/~ubuntu/adminArbitraryQuery.php");
		die();
	}


        try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	    $stmt = $_POST["query"];
	    $results = $db->query($stmt);
	    $out = '';
	    $out = $out."<table>";
            while($row = $results->fetch(PDO::FETCH_ASSOC)){
		$out = $out."<tr>";
		foreach($row as $thing){
			$out = $out."<th>";
			$out = $out . $thing;
			$out = $out . "</th>";
		}
                $out = $out."</tr>";
	    }
	    $out = $out."</table>";


            //disconnect from db
            $db = null;
        }
        catch(PDOException $e) {
            $st = 'Exception : '.$e->getMessage();
	echo $st;
	    header("Location: http://54.173.137.240/~ubuntu/adminArbitraryQuery.php?query=$stmt&out=$st");
            die('Exception : '.$e->getMessage());
        }

	header("Location: http://54.173.137.240/~ubuntu/adminArbitraryQuery.php?query=$stmt&out=$out");

?>
