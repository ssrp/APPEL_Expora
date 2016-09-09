<?php

    $target_file = "files/filname.xsl";
    $allowed = true;

    $FileType = pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
    
    // Allow Only XSL File For Uploading
    if($FileType != "xsl" && $FileType != "XSL")
    {
        echo "<h3>Error: File type not supported.</h3>";
        $allowed = false;
    }
    if($allowed) 
    {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        {
            echo "<h3>The file has been uploaded successfully! ^_^</h3><br />";
            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        }
        else
        {
            echo "<h3>Sorry, there was an error uploading your file.</h3><br />";
        }
    }
    else
    {
        echo "<h3>Sorry, your file was not uploaded.</h3><br />";
    }

?>