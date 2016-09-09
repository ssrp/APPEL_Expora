<?php
	// Create A Connection.
	include "connect.php";
				// Retrieve The Username And Password From The Caller
			$uname = $_POST["username"];
			$pass = $_POST["password"];

			// If Username Is Empty, Return Back!
			if($uname == "")
			{
					echo("<br>Please Enter a Username.");
					header( "refresh:2; url=../index.php"); 
			}
			else
			{
				// See If The Username Is In The Database.
				$order = "SELECT password FROM " . $prefix ."users WHERE username = '$uname' LIMIT 1";
				$result = runQuery($conn, $order);
				if(!$result)
				{
					echo "<br>Username not found.";
				}
				else
				{
					// Fetch The Row (OUTPUT)
					$row = fetchAssoc($result);

					// Get The Database Password
					$DBpass = $row["password"];

					// If The Password Matches With DBPassword, Then Authenticate. Otherwise Display Proper Message.
					if($pass == $DBpass)
					{
						//START A SESSION
						if(isset($_POST['username']))
						{
						   	session_start();
							$_SESSION['name']=$_POST['username'];
						  	//Storing the name of user in SESSION variable.
							header( "refresh:0; url=../expora.php"); 
						}
						else
						{
							echo("<br>There was some problem in logging in.");
							header( "refresh:2; url=../index.php"); 
						}
					}
					else
					{
						echo("<br>Username and Password do not match.");
						header( "refresh:2; url=../index.php"); 
					}
				}

				// Close The Connection.
				closeConnection($conn);
			}
?>