<?php
		include 'connect.php';


		$language = $_POST['language'];

		//Getting the query from the called JS function.
		$query = "SELECT field_name, field_table, " . $language . " FROM " . $prefix . "fields WHERE field_type = 'metadata'";
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
		$num_rows = getRows($query_run);
		$num_cols = getColumns($query_run);
		
		$table_name = "";
		$column_name = "";
		$output = "";
		$text = "";
		while ($row = fetchAssoc($query_run)) {
			$type = 0;
			foreach ($row as $val) {
				if($type == 0)
				{
					$column_name = $val;	
					$type = 1;
				}
				else if($type == 1)
				{
					$table_name = $val;
					$type = 2;
				}
				else if($type == 2)
				{
					$text = $val;
					$type = 0;
				}
			}
			$output = $output . ";" . $column_name . "|" . $table_name . "|" . $text;
		}
		echo $output;
		closeConnection($conn);
?>