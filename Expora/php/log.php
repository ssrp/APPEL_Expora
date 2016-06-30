<?php

    // Resume The Session
    session_start();
    if(!isset($_SESSION['name']))
    {
        header("location: index.php");
    }
    // Connect with the database.
    include 'connect.php';
    
    
    // Get Local IP Address
    function getLocalIP()
    {
        exec("ipconfig /all", $output);
        foreach($output as $line)
        {
            if (preg_match("/(.*)IPv4 Address(.*)/", $line))
            {
                $ip = $line;
                $ip = str_replace("IPv4 Address. . . . . . . . . . . :","",$ip);
                $ip = str_replace("(Preferred)","",$ip);
            }
        }
        return $ip;
    }

    // Get Current Time In The SQL DATETIME Format.
    $time = date_create()->format('Y-m-d H:i:s');

    // Get Local IP Address
    $localip = getLocalIP();
    $localip = str_replace(" ","",$localip);

    // User ID
    $userid = $_SESSION['name'];

    // Get The Query From The Caller
    $query = $_POST['query'];

    // Get The Query From The Caller
    $query_name = $_POST['query_name'];
    
    if($query_name == "")  
        $query_name = "unnamed";

    // Is query to be shared?
    $shared = $_POST['shared'];

    // Is it saved?
    $favourite = $_POST['favourite'];

    // Get Host IP Address
    $hostip = $_POST['hostip'];

    // Create The Query To Add Logs
    $add_log = "INSERT INTO " . $prefix . "logs VALUES (\"" . $time . "\", \"" . $localip . "\", \"" . $hostip . "\", \"" . $userid . "\", \"" . $query . "\", \"" . $shared . "\", \"" . $favourite . "\", \"" . $query_name . "\")";

    // Run The Query
    $query_run = runQuery($conn, $add_log);
    if(!$query_run)
    {
        echo "Error: " . returnError($conn);
        exit();
    }

    // Close The Connection
    mysqli_close($conn);
?>