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
	$findreplace = $_POST['findreplace'];
	$lowercase = $_POST['lowercase'];

		function getLocalIP(){
		$ip = "";
		exec("ipconfig /all", $output);
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
	    $name = $user . "_" . $timespaced . "_" . "treecloud.txt";
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
				  			$field = mb_convert_encoding($field, 'ISO-8859-1', mb_detect_encoding($field, mb_detect_order(), false));
					        fwrite($myfile, $field . " ");
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
			fwrite($myfile,  "a a a a a a a a a a a a a a a a a a a a a a a a a a a a a a");
			fwrite($myfile,  "\n");
		}
		$data = file("../downloads/" . $name); 
		$last_line = sizeof($data) - 1; 
		unset($data[$last_line]);
		fwrite($myfile, implode('', $data)); 
		closeConnection($conn);
		fclose($myfile);
		echo $name;
?>