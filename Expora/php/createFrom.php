<?php

/* THIS SCRIPT IS USED TO CREATE THE 'FROM' ELEMENT OF THE SQL QUERY
*/
			if($_POST['length'] == '1')
			{
				echo $_POST['tableOne'];
			}
			else
			{
				include 'connect.php';
				//Getting the query from the called JS function.
		
				$query = "SELECT primary_key, table1, foreign_key, table2 FROM " . $prefix . "table_links";
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
							$keyOne = $val;
							$type = 1;
						}
						else if($type == 1)
						{
							$tableOne = $val;
							$type = 2;
						}
						else if($type == 2)
						{
							$keyTwo = $val;
							$type = 3;
						}
						else if($type == 3)
						{
							$tableTwo = $val;
							$type = 0;
						}
					}
				}
				$from = $tableOne . " JOIN " . $tableTwo . " ON " . $tableOne . "." . $keyOne . " = " . $tableTwo . "." . $keyTwo;
				echo $from;
				closeConnection($conn);
			}
	
?>