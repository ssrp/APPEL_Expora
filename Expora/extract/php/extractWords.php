<?php
		include 'connect.php';

		//Getting the query from the called JS function.
		$query = $_POST['query'];
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
		$num_rows = getRows($query_run);
	    $num_cols = getColumns($query_run);
			while ($row = fetchArray($query_run)) {
			$flag = true;
		    foreach($row as $field) {
		    	if($flag)
		    	{
		        	echo $field . " ";
		        	$flag = false;
		        }
		        else
		        {
		        	$flag = true;
		        }
		    }
		}
		closeConnection($conn);
?>