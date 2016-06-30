<?php
	// Connect With The Database
	include 'connect.php';

	// Get The Username, Password, Re-entered Password And The Authentication Key From The Caller
	$uname = $_POST["username"];
	$pass = $_POST["password"];
	$repass = $_POST["repassword"];
	$authentication_key = $_POST["authentication_key"];

	// $auth Is The *REAL AUTHENTICATION KEY* Stored In connect.php Which If Matches With The One Entered, Go To The Next Step.
	if($authentication_key == $auth)
	{
		// If Password And Re-Entered Passwords Are Same
		if($pass == $repass)
		{
			// Add The Username and Password in the USERS Table. Signed Up!
			$order = "INSERT INTO " . $prefix . "users (username, password) VALUES	('$uname', '$pass')";

			$result = runQuery($conn, $order);
			if(!$result)
			{
				echo "Error: " . returnError($conn);
				exit();
			}
			if($result)
			{
				echo("<br>Registration Successful");
				//START A SESSION
				if(isset($_POST['username']))
				{
		    	   	session_start();
		    		$_SESSION['name']=$_POST['username'];
		    	  	//Storing the name of user in SESSION variable.
					header( "refresh:0; url=../expora.php" ); 
				}
			}
			else
			{
				echo("<br>There was some problem in registration.");
				header( "refresh:1; url=../index.php" ); 
			}
		}
		else{
			echo("<br>Password do not match.");
				header( "refresh:1; url=../index.php" );
			}
	}
	else
	{
		echo "Wrong Authentication Key !!";
		header( "refresh:1; url=../index.php" ); 
	}

	closeConnection($conn);
	
?>