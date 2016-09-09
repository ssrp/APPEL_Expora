<?php
		include 'connect.php';

		//Getting the query from the called JS function.
		$language = $_POST['language'];
		if($language == "EN")
			$query = "SELECT field_name, english FROM " . $prefix . "fields WHERE field_table='" . $_POST['table_name'] . "'";
		else
			$query = "SELECT field_name, french FROM " . $prefix . "fields WHERE field_table='" . $_POST['table_name'] . "'";
		echo $_POST['table_name'] . "|";
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
		$num_rows = getRows($query_run);
		$num_cols = getColumns($query_run);
		while ($row = fetchAssoc($query_run)) {
			foreach($row as $field) {
		    		echo $field . "|";
		    	
		    }
		}
		closeConnection($conn);
?>