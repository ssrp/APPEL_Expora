<?php

    // Resume The Session
    session_start();
    if(!isset($_SESSION['name']))
    {
        header("location: index.php");
    }
	include 'connect.php';

	$language = $_POST['language'];
	$userid = $_SESSION['name'];
	//Getting the query from the called JS function.
	$query = "SELECT query, shared, favourite, time, query_name FROM " . $prefix ."logs WHERE userid = '" . $userid . "' ORDER BY favourite DESC, time DESC";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$num_rows = getRows($query_run);
    $num_cols = getColumns($query_run);
	
	$output = "";
	while ($row = fetchAssoc($query_run)) {
		$type = 0;
		foreach ($row as $val) {
			if($type == 0)
			{
				$Q = $val;
				$type = 1;
			//	$Q = preg_replace('/\s+/', ' ', $Q);
			}
			else if($type == 1)
			{
				$S = $val;
				$type = 2;
			}
			else if($type == 2)
			{
				$F = $val;
				$type = 3;
			}
			else if($type == 3)
			{
				$T = $val;
				$type = 4;
			}
			else if($type == 4)
			{
				$N = $val;
				$type = 0;
			}
		}
		$output = $output . "#" . $Q . "|" . $S . "|" . $F . "|" . $T . "|" . $N;
		$output = substr($output, 0);
	}
	echo $output;
	closeConnection($conn);
?>