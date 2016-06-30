<?php

    // Resume The Session
    session_start();
    if(!isset($_SESSION['name']))
    {
        header("location: index.php");
    }
	include 'connect.php';

	$time = $_POST['time'];

	// Change Shared
	if($_POST['SF'] == "s")
	{
					//Getting the query from the called JS function.
					$query = "SELECT shared FROM " . $prefix ."logs WHERE time = '" . $time . "'";
					$query_run = runQuery($conn, $query);
					if(!$query_run)
					{
						echo "Error: " . returnError($conn);
						exit();
					}

					// Fetch The Row (OUTPUT)
					$row = fetchAssoc($query_run);
					$isShared = $row["shared"];

					if($isShared == "1")
					{
						$query = "UPDATE " . $prefix . "logs SET shared = '0' WHERE time = '" . $time . "'";
						$output = 0;

					}
					else
					{
						$query = "UPDATE " . $prefix . "logs SET shared = '1' WHERE time = '" . $time . "'";
						$output = 1;
					}
					$query_run = runQuery($conn, $query);
					if(!$query_run)
					{
						echo "Error: " . returnError($conn);
						exit();
					}
	}

	// Change Favourite
	else
	{
					//Getting the query from the called JS function.
					$query = "SELECT favourite FROM " . $prefix ."logs WHERE time = '" . $time . "'";
					$query_run = runQuery($conn, $query);
					if(!$query_run)
					{
						echo "Error: " . returnError($conn);
						exit();
					}

					// Fetch The Row (OUTPUT)
					$row = fetchAssoc($query_run);
					$isShared = $row["favourite"];

					if($isShared == "1")
					{
						$query = "UPDATE " . $prefix . "logs SET favourite = '0' WHERE time = '" . $time . "'"; 
						$output = 0;
					}
					else
					{
						$query = "UPDATE " . $prefix . "logs SET favourite = '1' WHERE time = '" . $time . "'";
						$output = 1; 
					}
					$query_run = runQuery($conn, $query);
					if(!$query_run)
					{
						echo "Error: " . returnError($conn);
						exit();
					}
	}
	echo $output;

	echo "\n". $query;
	closeConnection($conn);
?>