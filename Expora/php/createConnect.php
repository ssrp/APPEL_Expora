<?php

	/*THIS FILE IS USED TO CREATE THE connect.php FILE*/
	$servername = $_POST['servername'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$dbname = $_POST['dbname'];
	$auth = $_POST['auth'];
	$system = $_POST['system'];
	$tableOne = $_POST['tableOne'];
	$tableTwo = $_POST['tableTwo'];
	$tableOne_PK = $_POST['tableOne_PK'];
	$tableTwo_PK = $_POST['tableTwo_PK'];
	$prefix = $_POST['prefix'];
	$foreignK = $_POST['foreignK'];

		// Trying to create a new empty file with write right.
		$myfile = fopen('../installation/connect.php', 'w') or die('Unable to create file!');
		// Putting in the information.
		fwrite($myfile, "<?php\n");
		fwrite($myfile, "\t" . '// The Name Of The Connection Server.' . "\n");
		fwrite($myfile, "\t" . '$servername = \'' . $servername . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// Username To Connect To MySQL' . "\n");
		fwrite($myfile, "\t" . '$username = \'' . $username . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// Password Corresponding To The Username' . "\n");
		fwrite($myfile, "\t" . '$password = \'' . $password . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// The Database Name Which Has The Tables' . "\n");
		fwrite($myfile, "\t" . '$dbname = \'' . $dbname . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// The Authentication Key, Which Will Be Required For New SIGN UPs.' . "\n");
		fwrite($myfile, "\t" . '$auth = \'' . $auth . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// Choose The Database System Here. Values are either "PostgreSQL" or "MySQL"' . "\n");
		fwrite($myfile, "\t" . '$system = \'' . $system . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// The table names are stored here.' . "\n");
		fwrite($myfile, "\t" . '$tableOne = \'' . $tableOne . "';\n");
		fwrite($myfile, "\t" . '$tableTwo = \'' . $tableTwo . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// The primary keys of the tables are stored here.' . "\n");
		fwrite($myfile, "\t" . '$tableOne_PK = \'' . $tableOne_PK . "';\n");
		fwrite($myfile, "\t" . '$tableTwo_PK = \'' . $tableTwo_PK . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// Foreign Key(in table TWO) to connect to the first table is stored here.' . "\n");
		fwrite($myfile, "\t" . '$foreignK = \'' . $foreignK . "';\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// Prefix is stored here.' . "\n");
		fwrite($myfile, "\t" . '$prefix = \'' . $prefix . '\'; // PUT YOUR PREFIX HERE. BUT IF YOU DO IT, CHANGE THE TABLE NAMES IN THE DATABASE ACCORDINGLY');
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// Create A Connection' . "\n");
		fwrite($myfile, "\t" . 'if($system == "MySQL"){' . "\n");
		fwrite($myfile, "\t\t" . '$conn = mysqli_connect($servername, $username, $password, $dbname);' . "\n");
		fwrite($myfile, "\t\t" . '// Check The Connection' . "\n");
		fwrite($myfile, "\t\t" . 'if (!$conn)' . "\n");
		fwrite($myfile, "\t\t" . '{' . "\n");
		fwrite($myfile, "\t\t\t" . 'die("Connection Failed: " . mysqli_connect_error());' . "\n");
		fwrite($myfile, "\t\t" . '}' . "\n");
		fwrite($myfile, "\t\t" . '' . "\n");
		fwrite($myfile, "\t\t" . '// Set charset to UTF-8' . "\n");
		fwrite($myfile, "\t\t" . 'if (!$conn->set_charset("utf8"))' . "\n");
		fwrite($myfile, "\t\t" . '{' . "\n");
		fwrite($myfile, "\t\t\t" . 'printf("Error loading character set utf8: %s\n", $conn->error);' . "\n");
		fwrite($myfile, "\t\t" . '}' . "\n");
		fwrite($myfile, "\t\t" . '// Set charset to UTF-8' . "\n");
		fwrite($myfile, "\t\t" . 'if (!$conn->set_charset("utf8"))' . "\n");
		fwrite($myfile, "\t\t" . '{' . "\n");
		fwrite($myfile, "\t\t\t" . 'printf("Error loading character set utf8: %s\n", $conn->error);' . "\n");
		fwrite($myfile, "\t\t" . '}' . "\n");
		fwrite($myfile, "\t" . '}' . "\n");
		fwrite($myfile, "\t" . 'else' . "\n");
		fwrite($myfile, "\t" . '{' . "\n");
		fwrite($myfile, "\t\t" . '$conn = pg_connect("host=" . $servername . " dbname=" . $dbname . " user=" . $username . " password=" . $password . " options=\'--client_encoding=UTF\'");' . "\n");
		fwrite($myfile, "\t" . '}' . "\n");
		fwrite($myfile, "\t" . '' . "\n");
		fwrite($myfile, "\t" . '// Include Generic Functions.' . "\n");
		fwrite($myfile, "\t" . 'include "functions.php";' . "\n");
		fwrite($myfile, "\t" . 'include "functions2.php";' . "\n");
		fwrite($myfile, '' . '?>' . "\n");
		// Closing the file.
		fclose($myfile);		
?>