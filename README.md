# EXPORA

NOTE:
If The Website Is Running Slow, Then PLEASE COMMENT THE LINE NUMBER 874 of expora.php (The syntax here tries to connect with internet for generating the Server IP Address). If commented, default value of hostip: "No Internet" will be logged.

**************************************************************

TO CONNECT TO A NEW DATABASE:
1. Import The File: "For_New_DB/mydb.sql" in the database. (Current Prefix Used Is "", That Is, There Is No Prefix)
2. Edit The File: "For_New_DB/connect.php" accordingly and place(replace it with the old one) it in "php" folder of the expora.
3. Complete The Tables(fields, table_links) In The DBMS.

NOTE: In the table 'fields', the field_type column can have two values: 'text' or 'metadata' (CASE-SENSITIVE)

*************************************** TREE STRUCTURE ***************************************

Folder Expora{

		File index.php --> The Signin or Signup Options (start page of the website)

		File expora.php --> The Main Page Of Expora.

		Folder php{

				File connect.php --> This script Contains The Connection Attributes like dbname, username, password, authentication key etc. Change this script as per the needs.

				File functions.php --> This file contains the GENERIC FUNCTIONS that will be used to connect to different DBMS (currently supported for MySQL and PostgreSQL)

				File addRemoveSharedFav.php --> This script is used whenever the user clicks on any button in History panel of Expora.

				File buildHistory.php --> This script is used to build the History Panel Of Expora.

				File buildShared.php --> This script is used to build the Shared Panel Of Expora.

				File executeQuery.php --> This script is used to execute the query and show the output on the website.

				File loadFilterFields.php --> This script contains the code to load the fields in the selection list of fields.

				File loadMetadataFields.php --> This script contains the code to load the metadata checkboxes in the Export Metadata Option.

				File loadTextFields.php --> This script contains the code to load the textdata checkboxes in the Export Text Data Option.

				File log.php --> This script is used to log all the queries which are executed on the database.

				File login.php --> Used for logging in.

				File logout.php --> Used for logging out.

				File loadPrimaryKeys.php --> This file is used to load the primary key details in the metadata panel.

				File output_format_alceste.php --> Used to create the output alceste file.

				File output_format_csv.php --> Used to create the output csv file.

				File output_format_html.php --> Used to create the output html file.

				File output_format_lexico.php --> Used to create the output lexico file.

				File output_format_treecloud.php --> Used to create the output treecloud file.

				File output_format_txm.php --> Used to create the output txm file.

				File output_format_xsl.php --> Used for XSL Transformation.

				File signup.php --> Used for signing up.

				File updateMetadata.php --> Used for updating metadata. That is, adding the new metadata in the database.

				File index.html --> Used as a output if someone tries to go to "localhost/php/"
				
		}

		Folder images{
				File logo.png --> This is the logo for the website!
		}

		Folder js{

				File bootstrap.min.js --> Used for running Bootstrap.

				File index.js --> This script contains all the important functions() to run this website.

				File dataTables.bootstrap.min.js --> This is used to use the functionality of Data Tables(For History And Shared Panel In Expora)

				File jquery.dataTables.min.js --> Used to include jQuery used for Data Tables.

				File jquery.min.js --> Used for including jQuery.

				File index.html --> Used as a output if someone tries to go to "localhost/js/"

		}

		Folder downloads{

				File index.html --> Used as a output if someone tries to go to "localhost/downloads/"

				File xyz.abc
				<!-- This folder contains all the output formats created during the runtime. It's okay to delete the files inside this folder but keep the folder named 'downloads' present otherwise there will be errors in running the website. -->
		}

		Folder css{

				File bootstrap.min.css --> Used for bootstrap.

				File index.css --> Contains the CSS defined for the website explicitly.

				File dataTables.bootstrap.min.css --> This CSS File is used by the Data Tables Plugin.

				File fonts.css --> Contains the code to include fonts.

				File index.html --> Used as a output if someone tries to go to "localhost/css/"

		}

		Folder fonts{

				File code.ttf --> This font is used in the website.

				File index.html --> Used as a output if someone tries to go to "localhost/fonts/"

				File glyphicons-halflings-regular.* --> This font is used in the website by Data Tables.

		}
		File index.php --> The Signin or Signup Options (start page of the website)

		File expora.php --> The Main Page Of Expora.

}

Folder For_New_DB{
	
		File mydb.sql --> This contains a SQL file which contains the table structures for the tables used in Expora. Import Them If You Use It For Any Other Database.

		File connect.php --> This is an abstract for the connect.sql file(containing all the connection attributes) which should be edited before using.
}