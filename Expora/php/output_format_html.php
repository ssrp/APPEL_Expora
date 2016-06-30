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
	    $name = $user . "_" . $timespaced . "_" . "html.html";
		$myfile = fopen("../downloads/" . $name, "w") or die("Unable to create file!");


		fwrite($myfile, "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"
	   \"http://www.w3.org/TR/html4/strict.dtd\">\n");
		fwrite($myfile, "<html>\n");
		fwrite($myfile, "<head>\n");
		fwrite($myfile, "\t<title>Exported By - Expora " . $time . "</title>\n");
		fwrite($myfile, "<head>\n");
		fwrite($myfile, "<body>\n");
		fwrite($myfile, "\t<h1>Information</h1>\n");
		fwrite($myfile, "\t<!-- Logged Information -->\n");
		fwrite($myfile, "\t<h4>Date: " . $time . "<br>\n");
		fwrite($myfile, "\tUser: " . $user . "<br>\n");
		fwrite($myfile, "\tHost IP: " . $hostip . "<br>\n");
		fwrite($myfile, "\tLocal IP: " . $localip . "<br>\n");
		$query_run = runQuery($conn, $query);
		if(!$query_run)
		{
			echo "Error: " . returnError($conn);
			exit();
		}
		$num_rows = getRows($query_run);
	    $num_cols = getColumns($query_run);
	

		fwrite($myfile, "\tNo. of Columns: " . $num_cols . "<br>\n");
		fwrite($myfile, "\tNo. of Rows: " . $num_rows . "</h4>\n");
		fwrite($myfile, "\t<h1>SQL Query</h1>\n");
		fwrite($myfile, "\t<h4>" . $query . "</h4>\n");
		fwrite($myfile, "\t<h1>Results</h1>\n");
		//echo "<center><table style = 'border: 0.2em solid black;'>";
		fwrite($myfile, "\t<center><table style = 'border: 0.2em solid black;'>\n");
		fwrite($myfile, "\t\t<tr>");
		for($i=0; $i<$num_cols; $i++)
		{
		    $field = fetchFieldName($query_run, $i);
		    fwrite($myfile, "<th style = 'border: 0.2em solid black; padding: 0.5em'>" . $field . "</th>");
		}
		fwrite($myfile, "</tr>\n");
		while ($row = fetchArray($query_run)) {
			fwrite($myfile, "\t\t<tr>");
			$flag = true;
		    foreach($row as $field) {
			    	if($flag)
			    	{
				    	$field = trim(preg_replace('/\s+/', ' ', $field));
			  			$field = str_replace("<","&lt;",$field);
			  			$field = str_replace(">","&gt;",$field);
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
				        fwrite($myfile, "<td style = 'border: 0.2em solid black; padding: 0.5em'>" . $field . "</td>");
			        	$flag = false;
			        }
			        else
			        {
			        	$flag = true;
			        }
		    }
			fwrite($myfile,  "</tr>\n");
		}
		fwrite($myfile, "\t</table></center>\n");
		fwrite($myfile, "</body>\n");
		fwrite($myfile, "</html>\n");
		closeConnection($conn);
		fclose($myfile);
		echo $name;
?>