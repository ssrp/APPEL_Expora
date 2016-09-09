<?php
    // Resume The Session
    session_start();
    if(!isset($_SESSION['name']))
    {
        header("location: index.php");
    }

    // Uploaded File Type
    $FileType = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);

    // Is Uploading Allowed? Depends on the File Extension.
    $allowed = true;

    if($FileType != "csv" && $FileType != "CSV")
    {
        echo "<h3>Error: File type not supported.</h3>";
        $allowed = false;
    }
    if($allowed)
    {
        // If everything is okay, try to upload file
        if(move_uploaded_file($_FILES["file"]["tmp_name"], "../csv/replaceWords" . $_SESSION['name'] . ".csv"))
        {
            echo "DONE!";

        }
        else
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    else
    {
        echo "Sorry, your file was not uploaded.";
    }
?>