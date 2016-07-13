<?php
	include 'functions.php';
	$servername = $_POST['servername'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$dbname = $_POST['dbname'];
	$var = false;
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
		$conn = mysqli_connect($servername, $username, $password);
	
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


		$query = "CREATE DATABASE IF NOT EXISTS " . $dbname;

		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
		closeConnection($conn);

		// Create A Connection
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
		$conn = pg_connect("host=" . $servername . " user=" . $username . " password=" . $password . " options='--client_encoding=UTF8'");
		$query = "SELECT datname FROM pg_catalog.pg_database WHERE lower(datname) = lower('" . $dbname . "');";
		$query_run = runQuery($conn, $query);
		while ($row = fetchArray($query_run)) {
		    foreach($row as $field) {
		    	if(strpos($field, strtolower($dbname)) !== false)
		    	{
		    		$var = true;
		    		break;
		    	}

		   }
		}
		
		if(!$var)
		{
				$query = "CREATE DATABASE " . $dbname;
				$query_run = runQuery($conn, $query);
				if(!$query_run)
				{	
					echo returnError($conn);
					exit();
				}
		}
		closeConnection($conn);
		$conn = pg_connect("host=" . $servername . " dbname=" . $dbname . " user=" . $username . " password=" . $password . " options='--client_encoding=UTF8'");
	
		
	}

	// CREATE tables prefix_fields, logs, users, translations, table_links
	if($system == "MySQL")
	{
		$query = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"';
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}

		$query = 'SET time_zone = "+00:00"';
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
	}
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "fields (    id integer,    field_name text,    field_table text,    field_type text,    english text,    french text);";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	if($system == "MySQL")
	{
		$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "logs (time text,    localip text,    serverip text,    userid text,    query text,    shared integer,    favourite integer,    query_name text);";	
	}
	else
		$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "logs (\"time\" text,    localip text,    serverip text,    userid text,    query text,    shared integer,    favourite integer,    query_name text);";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{	
		echo "Error: " . returnError($conn);
		exit();
	}
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "table_links (    link_id integer NOT NULL,    primary_key text NOT NULL,    table1 text NOT NULL,    foreign_key text NOT NULL,    table2 text NOT NULL);";
    $query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "translations (    id text,    english text,    french text);";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "users (    username text,    password text);";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	if($system == "MySQL")
	{
		$query = "ALTER TABLE  " . $prefix . "fields  ADD PRIMARY KEY ( id )";
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}	

		$query = "ALTER TABLE  " . $prefix . "fields  MODIFY  id  int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the Field',AUTO_INCREMENT=1";
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
	}

	closeConnection($conn);
?>