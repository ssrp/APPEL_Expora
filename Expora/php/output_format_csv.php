<?php
	// Resume The Session
	session_start();
	if(!isset($_SESSION['name']))
	{
	    header("location: index.php");
	}
	include 'connect.php';


    // Replacement of Smileys?
    $r_smileys = $_POST['r_smileys'];
    $r_type = $_POST['r_type'];
	$findreplace = $_POST['findreplace'];
	$lowercase = $_POST['lowercase'];


		//Getting the query from the called JS function.
		$query = $_POST['query'];
			
		function getLocalIP(){
		exec("ipconfig /all", $output);
		    $ip = "";
		foreach($output as $line){
		        if (preg_match("/(.*)IPv4 Address(.*)/", $line)){
		            $ip = $line;
	   	         $ip = str_replace("IPv4 Address. . . . . . . . . . . :","",$ip);
	   	         $ip = str_replace("(Preferred)","",$ip);
	   		     }
	    	}
		return $ip;
		}
	    $hostip = $_POST['hostip'];
	    $time = date_create()->format('Y-m-d H:i:s');
	    $localip = getLocalIP();
	    $localip = str_replace(" ","",$localip);
	    $user = $_SESSION['name'];
	    $timespaced = str_replace(" ","_",$time);
	    $timespaced = str_replace(":",".",$timespaced);
	    $name = $user . "_" . $timespaced . "_" . "csv.csv";
		$myfile = fopen("../downloads/" . $name, "w") or die("Unable to create file!");

		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
		$num_rows = getRows($query_run);
	    $num_cols = getColumns($query_run);
	    $cols = array();
	    $input = "";
		for($i=0; $i<$num_cols; $i++)
		{
		    $field = fetchFieldName($query_run, $i);
		    $cols[] = $field;
		    $input = $input . "\"". $field . "\";";
		}
		$input = substr($input, 0, -1);
		fwrite($myfile, $input . "\n");
		while ($row = fetchArray($query_run)) {
			$i = 0;
			$input = "";
			$flag = true;
		    foreach($row as $field) {

			    	if($flag)
			    	{
				    	if(checkTextFields($cols[$i]))
				    	{
					    	// IF Text Fields Then Do This --
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
				    		$field = trim(preg_replace('/\s+/', ' ', $field));
					        $input = $input . ";\"" . $field . "\"";
				    	}
				    	else
				    	{
					    	// Otherwise --
					        $input = $input . ";" . $field;
				    	}
				    	$i++;
			        	$flag = false;
			        }
			        else
			        {
			        	$flag = true;
			        }
		    }
		    $input = substr($input, 1);
		    fwrite($myfile, $input . "\n");
		}
		closeConnection($conn);
		fclose($myfile);
		echo $name;
?>