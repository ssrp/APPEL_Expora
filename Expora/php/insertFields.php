<?php
	include 'functions.php';

	/*
		USED FOR installexpora.php
		THIS CODE IS USED TO INSERT THE FIELDS IN THE THIRD PANE, FOR PUTTING IN THE DESCRIPTION IN ENGLISH AND FRENCH
	*/
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


	$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $tableOne . "'";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$output = "";
	while ($row = fetchAssoc($query_run)) {
		$type = 0;
		foreach ($row as $val) {
			if($type == 0)
			{
				$Q = $val;
				$type = 1;
				$newQuery = "INSERT INTO " . $prefix . "fields (field_name, field_table) VALUES ('" . $Q . "', '" . $tableOne . "')" ;
				$Newquery_run = runQuery($conn, $newQuery);
				if(!$Newquery_run)
				{
					echo "Error: " . returnError($conn);
					exit();
				}
			}
			else
			{
				$type = 0;
			}
		}
		$output = $output . "#" . $Q . "|" . $tableOne;
		$output = substr($output, 0);
	}
	if($tableTwo != "")
	{
		$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_NAME='" . $tableTwo . "'";
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
		while ($row = fetchAssoc($query_run)) {
			$type = 0;
			foreach ($row as $val) {
				if($type == 0)
				{
					$Q = $val;
					$type = 1;
					$newQuery = "INSERT INTO " . $prefix . "fields (field_name, field_table) VALUES ('" . $Q . "', '" . $tableTwo . "')";
					$Newquery_run = runQuery($conn, $newQuery);
					if(!$Newquery_run)
					{
						echo "Error: " . returnError($conn);
						exit();
					}
				}
				else
				{
					$type = 0;
				}
			}
			$output = $output . "#" . $Q . "|" . $tableTwo;
			$output = substr($output, 0);
		}
	}
	
	echo $output;
	closeConnection($conn);
?>