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
		

    // Replacement of Smileys?
    $r_smileys = $_POST['r_smileys'];
    $r_type = $_POST['r_type'];
	$lowercase = $_POST['lowercase'];

	$findreplace = $_POST['findreplace'];
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
	    $name =  $user . "_" . $timespaced . "_" . "lexico.txt";
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
		for($i=0; $i<$num_cols; $i++)
		{
		    $field = fetchFieldName($query_run, $i);
		    $cols[] = $field;
		}
		while ($row = fetchArray($query_run)) {
			$i = 0;
			$flag = true;
		    foreach($row as $field) {
		    		fwrite($myfile, "<" . $tableOne . "_" . $tableTwo . ">");
			    	if($flag)
			    	{
				    	// IF Text Fields Then Do This --
				    	if(checkTextFields($cols[$i]))
				    	{
				    	}
				    	// Otherwise --
				    	else
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
				    		$field = trim(preg_replace('/\s+/', ' ', $field));
				  			$field = str_replace(" ","_",$field);
					        fwrite($myfile, "<" . $cols[$i] . "=" . $field . ">");
				    	}
				    	$i++;
			        	$flag = false;
			        }
			        else
			        {
			        	$flag = true;
			        }
		    }
			$i = 0;
			$flag = true;
		    foreach($row as $field) {

			    	if($flag)
			    	{
				    	// IF Text Fields Then Do This --
				    	if(checkTextFields($cols[$i]))
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
				    		$field = trim(preg_replace('/\s+/', ' ', $field));
				    		$field = trim(preg_replace('/\t+/', ' ', $field));
			  				$field = str_replace("<"," ",$field);
				  			$field = str_replace(">"," ",$field);
				  			$field = str_replace("&"," ",$field);
				  			fwrite($myfile, "<LexicoTextType=" . $cols[$i] . ">" . $field);
				    	}
				    	// Otherwise --
				    	else
				    	{
				    	}
				    	$i++;
			        	$flag = false;
			        }
			        else
			        {
			        	$flag = true;
			        }
		    }
			fwrite($myfile,  "\n");
		}
		closeConnection($conn);
		fclose($myfile);
		echo $name;
?>