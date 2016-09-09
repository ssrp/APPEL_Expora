<?php


	// Extract the column names of the text fields.
	$query = "SELECT field_name FROM " . $prefix . "fields WHERE field_type = 'text'";
	$query_run = runQuery($conn, $query);
	if(!$query_run)
	{
		echo "Error: " . returnError($conn);
		exit();
	}
	$num_rows = getRows($query_run);
    $num_cols = getColumns($query_run);

    $text_fields = array();
	while ($row = fetchAssoc($query_run)) {
		foreach ($row as $val) {
				$text_fields[] = $val;
		}
	}
	function checkTextFields($column)
	{
		global $text_fields;
		foreach($text_fields as $col)
		{
			if($col == $column)
				return true;
		}
		return false;
	}

	function replaceSmileys($field, $r_type)
	{

				$flag = 1;
				if($r_type == "mm_")
				{
					$flag = 1;
				}
				if($r_type == "mmc_")
				{
					$flag = 3;
				}
				if($r_type == "mmt_")
				{
					$flag = 4;
				}
				if($r_type == "mmm_")
				{
					$flag = 2;
				}
			    $file = fopen("../csv/smileys.csv", "r");
			    while(($line = fgetcsv($file, 10000, ",", "\"", "\n")) !== FALSE)
			    {
			    	$count = 0;
			    	foreach($line as $i)
			    	{
			    		if($count == 0)
			    		{
			    			$smiley = $i;
			    		}
			    		if($count == $flag)
			    		{
			    			$value = $r_type . $i;
			    		}
		    			$count++;
			    	}
			    	$field = str_replace($smiley, $value, $field);
				}
			    return $field;
			    fclose($file);
	}
	function replaceText($field)
	{
			    $file = fopen("../csv/replaceWords" . $_SESSION['name'] . ".csv", "r");
			    while(($line = fgetcsv($file, 10000, ",", "\"", "\n")) !== FALSE)
			    {
			    	$count = 0;
			    	foreach($line as $i)
			    	{
			    		if($count == 0)
			    		{
			    			$word = $i;
			    		}
			    		if($count == 1)
			    		{
			    			$replaceWith = $i;
			    		}
		    			$count++;
			    	}
			    	$field = str_replace($word, $replaceWith, $field);
				}
			    return $field;
			    fclose($file);
	}
?>