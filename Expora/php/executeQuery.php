<?php
	    // Resume The Session
	    session_start();
	    if(!isset($_SESSION['name']))
	    {
	        header("location: index.php");
	    }
		include 'connect.php';

		//Getting the query from the called JS function.
		$query = $_POST['query'];
		$r_smileys = $_POST['r_smileys'];
		$lowercase = $_POST['lowercase'];
		$findreplace = $_POST['findreplace'];
		$r_type = $_POST['r_type'];

		echo "<h2>Query:</h2>" . "<h4>" . $query . "</h4>";
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
		$num_rows = getRows($query_run);
	    $num_cols = getColumns($query_run);
		echo "<h3>Total Rows[Output]: " . $num_rows . "</h3>";
		echo "<h3>User: " . $_SESSION['name'] . "</h3>";
		echo "<center><table style = 'border: 0.2em solid black;'>";
			echo "<tr>";
			for($i=0; $i<$num_cols; $i++)
			{
			    $field = fetchFieldName($query_run, $i);
			   	echo "<th style = 'border: 0.2em solid black; padding: 0.5em'>" . $field . "</th>";
			}
			echo "</tr>";
			while ($row = fetchArray($query_run)) {
			echo "<tr>";
			$flag = true;
		    foreach($row as $field) {
		    	if($flag)
		    	{

						    if($r_smileys == "true")
						    {
						    	$field = replaceSmileys($field, $r_type);
						    }
						    if($findreplace == "true")
						    {
						    	$field = replaceText($field);
						    }
						    if($lowercase == "true")
						    {
						    	$field = mb_strtolower($field);
						    }
		        	echo "<td style = 'border: 0.2em solid black; padding: 0.5em'>" . $field . "</td>";
		        	$flag = false;
		        }
		        else
		        {
		        	$flag = true;
		        }
		    }
			echo "</tr>";
		}
		echo "</table></center>";
		closeConnection($conn);
?>