<?php
	// Resume The Session
	session_start();

	// If Logged In, Log Out!
	if(isset($_SESSION['name']))
	{
		unset($_SESSION['name']);
		// Return True, echo Works As A Return Value Here.
		echo "true";
	}

	// Redirect Anyway To The Index Page
	header("refresh:0; url=../index.php");
?>