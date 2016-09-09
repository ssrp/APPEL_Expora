<?php 

	// The Name Of The Connection Server.
	$servername = "<YOURSERVER>";

	// Username To Connect To MySQL
	$username = "<YOUR USERNAME>";

	// Password Corresponding To The Username
	$password = "<YOUR PASSWORD>";

	// The Database Name Which Has The Tables
	$dbname = "<DATABASE NAME>"; 

	// The Authentication Key, Which Will Be Required For New SIGN UPs.
	$auth = "<AUTHENTICATION KEY>";

	// Choose The Database System Here. Values are either 'PostgreSQL' or 'MySQL'
	$system = "<WHICH DBMS YOU USE? PostgreSQL or MySQL>";

	// The table names are stored here.
	$tableOne = "<NAME OF THE FIRST TABLE>";
	$tableTwo = "<NAME OF THE SECOND TABLE>";

	// The primary keys of the tables are stored here.
	$tableOne_PK = "<NAME OF THE PRIMARY KEY OF THE FIRST TABLE>";
	$tableTwo_PK = "<NAME OF THE PRIMARY KEY OF THE SECOND TABLE>";

	// Prefix is stored here.
	$prefix = ""; // PUT YOUR PREFIX HERE. BUT IF YOU DO IT, CHANGE THE TABLE NAMES IN THE DATABASE ACCORDINGLY


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
	        printf("Error loading character set utf8: %s\n", $con->error);
	    }
	}
	else
	{
		$conn = pg_connect("host=" . $servername . " dbname=" . $dbname . " user=" . $username . " password=" . $password . " options='--client_encoding=UTF8'");
	}


	// Include Generic Functions.
	include 'functions.php';
?>