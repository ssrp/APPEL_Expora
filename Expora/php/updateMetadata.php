<?php

    // Resume The Session
    session_start();
    if(!isset($_SESSION['name']))
    {
        header("location: index.php");
    }
    
    // Connect with the database.
    include 'connect.php';
    

    $userid = $_SESSION['name'];

    // Get The Query From The Caller
    $val = $_POST['val'];


    $file = fopen("../csv/" . $userid . ".csv", "w");
    fwrite($file, $val);
    fclose($file);
    $file = fopen("../csv/" . $userid . ".csv", "r");
    $flag = 0;
    $cols = array();
    $selected_table = "_blank";
    $french = array();
    $english = array();
    while(($line = fgetcsv($file, 10000, ";", '"', "\n")) !== FALSE)
    {
        if(substr($line[0], 0, strlen("lang-")) == "lang-")
        {
        }
        else
        {
            // First line, the primary key
            if($flag == 0)
            {
                $flag = 1;
                // Add new column to 'selected_table';
                // ALTER TABLE $selected_table ADD $column_name $type
                // Create array of cols
                foreach($line as $i)
                {
                    $cols[] = $i;
                    if($cols[0] == $tableOne_PK)
                    {
                        // ADD IN petitions
                        $selected_table = $tableOne;
                        if($cols[0] != $i)
                        {
                            // ADD $i in petitions
                            $query = "ALTER TABLE " . $selected_table . " ADD " . $i . " text";
                            //echo $query . "\n";
                            // Run The Query
                            $query_run = runQuery($conn, $query);
                            if(!$query_run)
                            {
                                echo "Error: " . returnError($conn);
                                exit();
                            }

                            // ADD new column in fields table.
                            $query = "INSERT INTO " . $prefix . "fields (field_name, field_table, field_type) VALUES ('" . $i . "', '" . $selected_table . "', 'metadata')";
                            //echo $query . "\n";
                            // Run The Query
                            $query_run = runQuery($conn, $query);
                            if(!$query_run)
                            {
                                echo "Error: " . returnError($conn);
                                exit();
                            }
                        }
                    }
                    else if($cols[0] == $tableTwo_PK)
                    {
                        // ADD IN comments
                        $selected_table = $tableTwo;
                        if($cols[0] != $i)
                        {
                            // ADD $i in comments
                            $query = "ALTER TABLE " . $selected_table . " ADD " . $i . " text";
                            //echo $query . "\n";
                            // Run The Query
                            $query_run = runQuery($conn, $query);
                            if(!$query_run)
                            {
                                echo "Error: " . returnError($conn);
                                exit();
                            }

                            // ADD new column in fields table.
                            $query = "INSERT INTO " . $prefix . "fields (field_name, field_table, field_type) VALUES ('" . $i . "', '" . $selected_table . "', 'metadata')";
                            // Run The Query
                            $query_run = runQuery($conn, $query);
                            if(!$query_run)
                            {
                                echo "Error: " . returnError($conn);
                                exit();
                            }
                        }
                    }
                }
            }

            // Values for the column
            else
            {
                $flag = 0;
                $values = array();
                $set = "";
                $where = "";
                foreach($line as $i)
                {
                    if($i[0] != "\"" || $i[strlen($i) - 1] != "\"")
                        $i = "'" . $i . "'";
                    $values[] = $i;
                }
                $i = 0;
                foreach($cols as $COL)
                {
                    if($flag == 0)
                    {
                        $flag = 1;
                        $where = $COL . " = " . $values[$i];
                    }
                    else
                    {
                        $set = $set . ", " . $COL . "=" . $values[$i];
                    }
                    $i++;
                }
                $set = substr($set, 1);
                // UPDATE '$selected_table' SET cols[i] = value[i] (1 to n) WHERE prim[0] = value[0]
                $query = "UPDATE " . $selected_table . " SET " . $set . " WHERE " . $where;
                //echo $query . "\n";
                // Run The Query
                $query_run = runQuery($conn, $query);
                if(!$query_run)
                {
                    echo "Error: " . returnError($conn);
                    exit();
                }
            }
        }
    }
    fclose($file);
    unset($line);

    $file = fopen("../csv/" . $userid . ".csv", "r");
    while(($line = fgetcsv($file, 10000, ";", '"', "\n")) !== FALSE)
    {
        if(substr($line[0], 0, strlen("lang-")) == "lang-")
        {
            $flag = 0;
            $lang = "";
            $count = 0;
            foreach($line as $i)
            {
                if($flag == 0)
                {
                    $flag = 1;
                    if($i == "lang-english")
                        $lang = "english";
                    else
                        $lang = "french";
                }
                else
                {
                    // UPDATE fields SET $lang = $i WHERE name = "$cols[$count]";
                    $query = "UPDATE " . $prefix . "fields SET " . $lang . " = '" . $i . "' WHERE field_name = '" . $cols[$count] . "'";
                    // echo $query . "\n";
                    // Run The Query
                    $query_run = runQuery($conn, $query);
                    if(!$query_run)
                    {
                        echo "Error: " . returnError($conn);
                        exit();
                    }
                }
                $count++;
            }
        }
    }

    // Close The Connection
    closeConnection($conn);
    fclose($file);
    unlink("../csv/" . $userid . ".csv");
?>