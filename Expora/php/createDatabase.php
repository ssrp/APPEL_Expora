<?php
	include 'functions.php';
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
	}
	else
	{
		$conn = pg_connect("host=" . $servername . " user=" . $username . " password=" . $password . " options='--client_encoding=UTF8'");
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
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "fields  ( id  int(11) NOT NULL COMMENT 'ID of the Field',   field_name  text NOT NULL COMMENT 'Name of the Column/Field',   field_table  text NOT NULL COMMENT 'Table which has this field',   field_type  text NOT NULL COMMENT 'Type - Text / Metadata',   english  text,   french  text) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "logs  (  time  text NOT NULL,   localip  text NOT NULL,   serverip  text NOT NULL,   userid  text NOT NULL,   query  text NOT NULL,   shared  int(11) NOT NULL,   favourite  int(11) NOT NULL,   query_name  text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "table_links  (   link_id  int(11) NOT NULL,   primary_key  text NOT NULL,   table1  text NOT NULL, foreign_key  text NOT NULL,   table2  text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "translations  (  id  text NOT NULL,   english  text NOT NULL,   french  text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$query = "CREATE TABLE IF NOT EXISTS  " . $prefix . "users  (  username  text NOT NULL,   password  text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
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
	closeConnection($conn);
?>