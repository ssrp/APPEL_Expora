<?php

		include 'connect.php';
/* THIS SCRIPT IS USED TO CREATE THE 'FROM' ELEMENT OF THE SQL QUERY
*/
			if($_POST['length'] == '1')
			{
				echo $_POST['tableOne'];
			}
			else
			{
				$from = $tableOne . " JOIN " . $tableTwo . " ON " . $tableOne . "." . $tableOne_PK . " = " . $tableTwo . "." . $foreignK;
				echo $from;
			}
?>