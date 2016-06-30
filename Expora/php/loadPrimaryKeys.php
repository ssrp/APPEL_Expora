<?php

    // Resume The Session
    session_start();
    if(!isset($_SESSION['name']))
    {
        header("location: index.php");
    }
	include 'connect.php';
	echo "#" . $tableOne . "|" . $tableOne_PK . "#" . $tableTwo . "|" . $tableTwo_PK;
	closeConnection($conn);
?>