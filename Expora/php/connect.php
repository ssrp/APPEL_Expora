<?php 

	// The Name Of The Connection Server.
	$servername = "localhost";

	// Username To Connect To MySQL
	$username = "root";

	// Password Corresponding To The Username
	$password = "root";

	// The Database Name Which Has The Tables
	$dbname = "appel"; 

	// The Authentication Key, Which Will Be Required For New SIGN UPs.
	$auth = "Expora";

	// Choose The Database System Here. Values are either 'PostgreSQL' or 'MySQL'
	$system = "MySQL";

	// The table names are stored here.
	$tableOne = "petitions";
	$tableTwo = "comments";

	// The primary keys of the tables are stored here.
	$tableOne_PK = "id_pets";
	$tableTwo_PK = "id_signs";

	// Prefix is stored here.
	$prefix = "petitions_"; // PUT YOUR PREFIX HERE. BUT IF YOU DO IT, CHANGE THE TABLE NAMES IN THE DATABASE ACCORDINGLY


	// Create A Connection
	if($system == "MySQL")
	{
		$conn = mysqli_connect($servername, $username, $password, $dbname);
	
		// Check The Connection
		if (!$conn)
		{
			die("Connection Failed: " . mysqli_connect_error());
		}

	    // Set charset to UTF-8
	    if (!$conn->set_charset("utf8"))
	    {
	        printf("Error loading character set utf8: %s\n", $conn->error);
	    }
	}
	else
	{
		$conn = pg_connect("host=" . $servername . " dbname=" . $dbname . " user=" . $username . " password=" . $password . " options='--client_encoding=UTF8'");
	}


	// Include Generic Functions.
	include 'functions.php';
?>