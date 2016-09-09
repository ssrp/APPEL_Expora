<?php

    $xsl_file = $_POST['xsl_filename'];
    $model_file = $_POST['filename'];

    // Uploaded File Type
    $FileType = pathinfo(basename($_FILES["xsl_file"]["name"]), PATHINFO_EXTENSION);

    // Replacement of Smileys?
    $r_smileys = $_POST['r_smileys'];
    $r_type = $_POST['r_type'];

    // Is Uploading Allowed? Depends on the File Extension.
    $allowed = true;

    // Allow Only XSL File For Uploading
    if($FileType != "xsl" && $FileType != "XSL")
    {
        echo "<h3>Error: File type not supported.</h3>";
        $allowed = false;
    }
    if($allowed)
    {
        // If everything is okay, try to upload file
        if(move_uploaded_file($_FILES["xsl_file"]["tmp_name"], "../xsl/" . $xsl_file))
        {
		        echo "The file has been uploaded successfully! ^_^";

            	// Process The Output!

	            rename('../downloads/' . $model_file, '../xsl/' . $model_file);


				$xslDoc = new DOMDocument();
				$xslDoc->load('../xsl/' . $xsl_file);

				$modelDoc = new DOMDocument();
				$modelDoc->load('../xsl/' . $model_file);

				$proc = new XSLTProcessor();
				$proc->importStylesheet($xslDoc);
				echo $proc->transformToXML($modelDoc);

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