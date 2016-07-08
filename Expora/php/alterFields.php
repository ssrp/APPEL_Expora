<?php
	include 'functions.php';
	// Create A Connection
	$servername = $_POST['servername'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$dbname = $_POST['dbname'];
	$auth = $_POST['auth'];
	$system = $_POST['system'];
	$tableOne = $_POST['tableOne'];
	$tableTwo = $_POST['tableTwo'];
	$tableOne_PK = $_POST['tableOne_PK'];
	$tableTwo_PK = $_POST['tableTwo_PK'];
	$prefix = $_POST['prefix'];

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

		$query = $_POST['query'];
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}

	closeConnection($conn);
?>