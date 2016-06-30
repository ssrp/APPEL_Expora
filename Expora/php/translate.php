<?php
	    // Resume The Session
	    session_start();
	    if(!isset($_SESSION['name']))
	    {
	        header("location: index.php");
	    }
		include 'connect.php';

		//Getting the query from the called JS function.
		$lang = $_POST['lang'];

		if($lang == "FR" || $lang == "fr")
		{
			$lang = "french";
		}
		else
		{
			$lang = "english";
		}
		$query = "SELECT id, " . $lang . " FROM " . $prefix . "translations";

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
					$id = $val;	
					$type = 1;
				}
				else if($type == 1)
				{
					$description = $val;
					$type = 0;
				}
			}
			$output = $output . "##" . $id . "|" . $description;
			$output = substr($output, 0);
		}
		echo $output;
	closeConnection($conn);
?>