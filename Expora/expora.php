<?php
	// Resume a session.
	session_start();
	
	// If not started, then go back to index.php
	if(!isset($_SESSION['name']))
	{
		header("location: index.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title class = "interface_title">Export Text Corpora From The Database</title>

	<!--
		Including the CSS Files Required!
		-->
	<link href = "css/fonts.css" rel = "stylesheet" type = "text/css" />
	<link href = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css" />
	<link href = "css/dataTables.bootstrap.min.css" rel = "stylesheet" type = "text/css" />
	<link href = "css/index.css" rel = "stylesheet" type = "text/css" />
 	<link rel="stylesheet" href="css/bootstrap-select.min.css">

	<!--
		Setting The Logo!
		-->
	<link rel="shortcut icon" href="images/logo-small.png">

	<!--
		Using UTF-8 Font Type 
		-->
	<meta charset="utf-8">
</head>

	<!--
		The Code Starts with the 'start()' function in javascript. It does a lot of jobs, like loading the data from the database, loading up the fields etc.
		-->
<body onload = "start();">

	<!--
		This Will Be Used To Download The Output Files
		-->
	<a href= "" download="" style= "display:none" id = "download_file" target = "_blank"></a>


	<!--
		The Main Navigation Bar (At The Top)
		-->
	<div id = "toolbar">
		<ul class="nav nav-tabs">
		    <li class="navbar-header" onclick = "switch_about()"><a href="#"><b><img src = "images/logo-medium.png" style ="height:2em; margin:-0.5em; margin-top: -0.8em;margin-right:0.5em; transform:scale(1.4)"><span class = "interface_toolbar_expora">EXPORA</span></b></a></li>
			<li role="presentation" id = "toolbar_subcorpora" onclick = "switch_subcorpora()"><a href="#"><span class = "interface_toolbar_subcorpora">Extract Sub-Corpus</span></a></li>
			<li role="presentation" id = "toolbar_history" onclick = "switch_history()"><a href="#"><span class = "interface_toolbar_history">Your History</span></a></li>
			<li role="presentation" id = "toolbar_shared" onclick = "switch_shared()"><a href="#"><span class = "interface_toolbar_shared">Shared Queries</span></a></li>
			<li role="presentation" id = "toolbar_sqlquery" onclick = "switch_sqlquery()"><a href="#"><span class = "interface_sql_title">SQL Query</span></a></li>
			<li role="presentation" id = "toolbar_metadata" onclick = "switch_metadata()"><a href="#"><span class = "interface_toolbar_metadata">Add Metadata</span></a></li>
			<li role="presentation" class="navbar-right"></li>
			<li role="presentation" id = "logout" class="navbar-right" onclick = "sign_out()"><a href="#"><span class = "interface_toolbar_logout">Logout</span></a></li>
			<li role="presentation" id = "language" class="dropdown navbar-right">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				    <span class = "interface_toolbar_language">Language</span> <span class="caret"></span>
				</a>
			    <ul class="dropdown-menu">
			      <li onclick = "changeLang('EN')" class = "text-center"><a href = "#"><span class = "interface_toolbar_language_english">English</span></a></li>
			      <li onclick = "changeLang('FR')" class = "text-center"><a href = "#"><span class = "interface_toolbar_language_french">French</span></a></li>
			    </ul>
			</li>
		</ul>
	</div>

	<div id = "expora_about">
					<h1 class = "text-center"><u>Expora</u> - <u>Ex</u>tract Cor<u>pora</u></h1>
					<div class ="col-md-10 col-md-offset-1" style = "font-size:1.2em">

					</div>
					<div id = "about_after" class = "col-md-10 col-md-offset-1" style = "font-size:1.3em">
						<nav class = "text-center" style = "margin-bottom: 0em">
							<ul class="pagination">
								<li><a href="#" onclick = "gotoABOUT(0)"><spna class = "">About Expora</span></a></li>
								<li><a href="#" onclick = "gotoABOUT(1)"><spna class = "">Using Extract Sub-Corpus</span></a></li>
								<li><a href="#" onclick = "gotoABOUT(2)"><spna class = "">Your History and Shared Queries</span></a></li>
								<li><a href="#" onclick = "gotoABOUT(3)"><spna class = "">Using SQL Query Pane</span></a></li>
								<li><a href="#" onclick = "gotoABOUT(4)"><spna class = "">Using Add Metadata Pane</span></a></li>
								<li><a href="#" onclick = "gotoABOUT(5)"><spna class = "">The Team</span></a></li>

							</ul>
						</nav>
						<div class = "about_options">
							<h3>About Expora</h3>
							Expora is a web-application/web-interface which helps you extract any database which as maximum two tables, in many export formats(HTML, Lexico, TreeCloud, etc). The supported database management systems are MySQL and PostgreSQL. The application is made as generic as possible and currently, it's in French and English language. The code behind Expora is very easy to understand and can be edited/improved for any specific use.
							<br>
							You can connect your database by altering the connect.php file and adding the appropriate tables in the database. Here is the complete app, you may also find a very detailed installation process here:<br>
							<center><a href = "https://github.com/ssrp/APPEL_Expora" class = "text-center btn btn-success" target = "_blank">Download Expora</a></center>
							<h3>Database Is Secure!</h3>
							The database is properly protected from the people who are not authorized to use Expora. They should have an account to access the database. So, there's no loss/leakage of data. When signing up, an <b>Authentication Key</b> is required by the user without which, he/she can not access Expora. If someone tries to use any 'bad' queries which might affect the database, he/she will be caught because every time user runs the query, his username, query, time of execution and IP address is logged.
							<br>
							<h3>Using Expora</h3>
							If you have an experience with SQL, you can use the <b>SQL Query</b> pane to export the data in any format you want. If not, then Expora has a <b>Extract Sub-Corpus</b> pane using which, you can select the data that you want to extract and download the output in varied formats. It also has the options for filters and sorting the data(so, you don't need to have knowledge about SQL, Expora will do the job!). Pretreatments(like replacement of smileys, text etc), XSL Transformations, Visualisations are some of the features of Expora.
							<br>
							Whenever a user executes the query, it gets saved in the <b>History</b> pane for the furthur use. Also, if the user wants to share the query, he can choose the share option and it'll be visible to all the users who use Expora(under same database).
							<br><br>
						</div>
						<div class = "about_options">
								<h3>How to use - EXTRACT SUB-CORPUS</h3>
								<br>
								<ol>
										<li>
											<b>Select Exporting Text Data</b><br>
											Just select the text data that you want to extract and click on next
										</li>
										<li>
											<b>Select Exporting Metadata</b><br>
											Select the metadata that you want to extract and click next.
										</li>
										<li>
												<b>Using Filters</b><br>
											Filters are used to add some conditions in the query, For example, I want to extract all cars whose name start with S. You can achieve the "whose name start with S" using filters. 
										
										</li>
										<li>
												<b>Sorting</b><br>
											You can sort the output using any of the fields in asc or dsc order.
										</li>
										<li>
											<b>Pretreatments</b><br>
											Choose the pretreatments like all lowercase(output to be lowercase), replacement of smileys(explain), use csv file to find and replace from a file.
										</li>
										<li>
											<b>Output Format</b><br>
											Choose the output formats that you want to use, if you'd like to use the XSL Transformation, then upload the XSL file and the Expora will transform a simple XML (Example here) file into the output using the XSL File you uploaded.
											You can also share the generated query with other users working and add the query to your favourites(it won't be shown to all)
										</li>
								</ol>
									Now clicking on '<b>EXPORT!</b>' will create the output for you!
						</div>
						<div class = "about_options">
							<h3>What is 'Your History'?</h3>
							This is a table which contains all the queries that you executed so far. If you do not have knowledge of SQL, then also you can get to know which query you used, otherwise, <b>you can use the search field to locate the query by the name you gave it</b>.
								<br>
							<h3>What are 'Shared Queries'?</h3>
							You can see all the queries which are made public to all the other users working with Expora under same environment.
						</div>
						<div class = "about_options">
							<h3>How to use 'SQL Query' Pane?</h3>
							You can enter your SQL Query in the provided fields and choose the pretreatments and file format the same way you choose for Extract Sub Corpus and you are good to go!
						</div>
						<div class = "about_options">
							<h3>How To Add Metadata?</h3>
							This pane is used to add some new column to the current available tables. There are four things that a new column needs: 
							<ul>
								<li>Column name</li>
								<li>Which table should has it?</li>
								<li>Its description (to be shown in the extracting fields)</li>
								<li>The values corresponding to different rows in that table(using primary key)</li>
							</ul>
							<b>Note</b>: PRIMARY_KEY is the <u>key of the table in which the new column has to be inserted</u>.
							<br>For that, we have the following format:
							<br>
							<b>
									<br>"lang-english";"DESCRIPTION IN ENGLISH"
									<br>"lang-french";"DESCRIPTION IN FRENCH"
									<br>"PRIMARY_KEY";"NEW_COLUMN_NAME"
									<br>"KEY_VALUE1";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE1"
									<br>"KEY_VALUE2";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE2"
									<br>"KEY_VALUE3";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE3"
									<br>"KEY_VALUE4";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE4"
									<br>"KEY_VALUE5";"COLUMN_VALUE CORRESPONDING TO KEY_VALUE5"
							</b>
							<br>
							<br>
							You can add more columns using semicolons. Also, there's an option for uploading a CSV File if the data is too large to handle!
							<br>
							The primary key pane shows the description about the primary keys of the tables used.
						</div>
						<div class = "about_options">
							<h3>Meet The Developers!</h3>
							<b>Expora</b> is designed and developed by <b>Mr. Sai Samarth R Phaye</b> under the supervision of <b>Dr. Philippe Gambette</b> and <b>Dr. Jean-Marc Leblanc</b> at Laboratoire d'Informatique Gaspard-Monge, UPEM.
							
							<center>
								<a href = "https://plus.google.com/+SaiSamarthRPhaye/posts" target = "_blank">
									<div class = "display_pictures">
										<img class = "display_pictures_img" src = "images/sai.jpg">
										<hr style = "margin:0.2em; padding:0em">
										<b>Mr. Sai Samarth R Phaye</b>
									</div>
								</a>
								<a href = "http://igm.univ-mlv.fr/~gambette/indexENG.php" target = "_blank">
									<div class = "display_pictures">
									<img class = "display_pictures_img" src = "images/philippe.jpg">
										<hr style = "margin:0.2em; padding:0em">
										<b>Dr. Philippe Gambette</b>
									</div>
								</a>
								<a href = "http://ceditec.u-pec.fr/membres/enseignants-chercheurs/leblanc-jean-marc-341913.kjsp" target = "_blank">
									<div class = "display_pictures">
									<img class = "display_pictures_img" src = "images/jeanmarc.jpg">
										<hr style = "margin:0.2em; padding:0em">
										<b>Dr. Jean-Marc Leblanc</b>
									</div>
								</a>
							</center>
							
						</div>
					</div>

	</div>


	<!--
		SQL Query Form!
		-->
	<div id = "form_sqlquery">


						<!--
							Navigation For The SubCorpora Form
							-->
						<nav class = "text-center" style = "margin-bottom: 0em">
							<ul class="pagination">
								<li><a href="#" onclick = "gotoSQL(0)"><spna class = "interface_sql_title">SQL Query</span></a></li>
								<li><a href="#" onclick = "gotoSQL(1)"><spna class = "interface_pretreatments_title">Pretreatments</span></a></li>
								<li><a href="#" onclick = "gotoSQL(2)"><spna class = "interface_format_title">File Format</span></a></li>
							</ul>
						</nav>

						<div class = "text-center sql_options">
							<form id = "sql_query_form">
								<h3 class = "text-center" style = "margin:0em">- <span class = "interface_sql_title">SQL Query</span> -</h3>
								<div class = "text-center col-md-10 col-md-offset-1" style= "padding:1em; margin-top:0em">
									<div class="input-group col-md-12" style = "margin-bottom:0.2em">
					  					<span class="input-group-addon" id="basic-addon1">SELECT</span>
								 		<input type="text" class="form-control" placeholder="table1.column_1, table1.column_2, table3.column_3 .." aria-describedby="basic-addon1" id = "sql_query_form_input_select">
									</div>
									<div class="input-group col-md-12" style = "margin-bottom:0.2em">
					  					<span class="input-group-addon" id="basic-addon1">FROM</span>
								 		<input type="text" class="form-control" placeholder="table1, table2, table3 .." aria-describedby="basic-addon1" id = "sql_query_form_input_from">
									</div>
									<div class="input-group col-md-12" style = "margin-bottom:0.2em">
					  					<span class="input-group-addon" id="basic-addon1">WHERE</span>
								 		<input type="text" class="form-control" placeholder="expression" aria-describedby="basic-addon1" id = "sql_query_form_input_where">
									</div>
									<div class="input-group col-md-12" style = "margin-bottom:0.2em">
					  					<span class="input-group-addon" id="basic-addon1">ORDER BY</span>
								 		<input type="text" class="form-control" placeholder="column_name ASC/DESC" aria-describedby="basic-addon1" id = "sql_query_form_input_order">
									</div>
								<nav>
								  <ul class="pager">
								    <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
								    <li class="next" onclick = "gotoSQL(curr_sql+1)"><a href="#"><span class = "interface_button_next">Next</span> <span aria-hidden="true">&rarr;</span></a></li>
								  </ul>
								</nav>	
								</div>
							</form>
						</div>


						<!--
							Pretreatments Division
							-->
						<div class = "text-center sql_options">
							<div id = "sql_output_pretreatments">
								<h3 style = "margin:0em" class = "text-center"> - <span class = "interface_output_title">Output</span> - </h3>
								<h4 style = "padding: 0.5em; margin: 0em" id = "output_pretreatments_title"><span class = "interface_pretreatments_title">Pretreatments</span>:</h4>
								<table>
									<tr>
										<td>
											<label><input type="checkbox" name="output_pretreatments_lowercase" /> <div class = "output_pretreatments_lowercase" style = "display: inline-block"><span class = "interface_pretreatments_lowercase">All Lowercase</span></div></label>
										</td>			
									</tr>
									<tr>
										<td>
											
											<label><input type="checkbox" name="output_pretreatments_replace_smileys" /> <div class = "output_pretreatments_replace_smileys" style = "display: inline-block"><span class = "interface_pretreatments_smileys">Replacement of Smileys</span></div>
											<ul style = "list-style-type: none;">
												<li>
													<label><input type="radio" name = "output_pretreatments_replace_smileys_options" class="output_pretreatments_replace_smileys_name" /> <div style = "display: inline-block"><span class = "interface_pretreatments_smileys_name">Replace By Name</span></div></label>
												</li>
												<li>

													<label><input type="radio" name = "output_pretreatments_replace_smileys_options" class="output_pretreatments_replace_smileys_cat" /> <div style = "display: inline-block"><span class = "interface_pretreatments_smileys_name">Replace By Meaning</span></div></label>
												</li>
												<li>
													<label><input type="radio" name = "output_pretreatments_replace_smileys_options" class="output_pretreatments_replace_smileys_meaning" /> <div style = "display: inline-block"><span class = "interface_pretreatments_smileys_name">Replace By Category</span></div></label>
												</li>
												<li>
													<label><input type="radio" name = "output_pretreatments_replace_smileys_options" class="output_pretreatments_replace_smileys_type" /> <div style = "display: inline-block"><span class = "interface_pretreatments_smileys_name">Replace By Type</span></div></label>
												</li>
											</ul>
												</label>
										</td>
									</tr>				
									<tr>
										<td>
											<div class="input-group" style = "margin:0em; padding:0.1em">
										      <span class="input-group-addon" style = "transform:translateX(-1em)">
										        <input type="checkbox" class = "output_pretreatments_find_replace" aria-label="Use Find And Replacement">
										      </span>
												<span class = "text-center" id = "output_pretreatments_find_replace_file_first_value" style = "display:block" style = "transform:translateX(-1em)"></span>
								
												<label class="form-control btn btn-primary btn-file" for="output_pretreatments_find_replace_file_first" style = "transform:translateX(-1em)">
												    <input id="output_pretreatments_find_replace_file_first" name = "output_pretreatments_find_replace_file_first" type="file" style="display:none;" onchange="if($(this).val() != ''){$('#output_pretreatments_find_replace_file_first_value').html('File: '.concat($(this).val()));}">
												    <span class = "interface_pretreatments_findreplace">Find / Replace from a File</span>
												</label>
										    </div>

										</td>
									</tr>
								</table>	
								<nav>
								  <ul class="pager">
								    <li class="previous" onclick = "gotoSQL(curr_sql-1)"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
								    <li class="next" onclick = "gotoSQL(curr_sql+1)"><a href="#"><span class = "interface_button_next">Next</span> <span aria-hidden="true">&rarr;</span></a></li>
								  </ul>
								</nav>	
							</div>
						</div>




						<!--
							Output Format Division
							-->
						<div class = "text-center sql_options">
							<div id = "sql_output_format">
								<h3 style = "margin:0em" class = "text-center"> - <span class = "interface_output_title">Output</span> - </h3>
								<h4 style = "padding: 0.5em; margin: 0em" id = "output_format_title"><span class = "interface_format_title">File Format</span>:</h4>
								<table>
									<tr>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="output_format_txm" id = "sql_output_format_txm_radio"><div id = "sql_output_format_txm" style = "display: inline-block">TextObserver / TXM</div></label>
											</div>
										</td>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="output_format_treecloud" id = "sql_output_format_treecloud_radio"><div id = "sql_output_format_treecloud" style = "display: inline-block">TreeCloud</div></label>
											</div>
										</td>					
									</tr>
									<tr>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="sql_output_format_alceste" id = "sql_output_format_alceste_radio"><div id = "sql_output_format_alceste" style = "display: inline-block">Alceste</div></label>
											</div>
										</td>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="sql_output_format_lexico" id = "sql_output_format_lexico_radio"><div id = "sql_output_format_lexico" style = "display: inline-block">Lexico</div></label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="sql_output_format_csv" id = "sql_output_format_csv_radio"><div id = "sql_output_format_csv" style = "display: inline-block">CSV</div></label>
											</div>
										</td>

										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="sql_output_format_html" id = "sql_output_format_html_radio"><div id = "sql_output_format_html" style = "display: inline-block">HTML</div></label>
											</div>
											
										</td>
									</tr>
								</table>

								<h5>
									<div class="checkbox" style = "margin:0em; padding:0.1em">
										<label><input type="checkbox" onclick = "addShared()"><div style = "display: inline-block"><span class = "interface_sql_output_share">Share this query with others</span>!</div></label>
									</div>
									<div class="checkbox" style = "margin:0em; padding:0.1em">
										<label><input type="checkbox" onclick = "addFavourite()"><div style = "display: inline-block"><span class = "interface_sql_output_favourites">Add to favourites</span>!</div></label>
									</div>

									<input type="text" class = "output_query_name form-control" placeholder="Name Your Query (Not Compulsory)" aria-describedby="basic-addon1">
									
								</h5>
								<nav>
								  <ul class="pager">
								    <li class="previous" onclick = "gotoSQL(curr_sql-1)"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
								    <li class="next" onclick = "runQuery()" name = "submit_form"><a href="#"><span class = "interface_button_export">EXPORT</span>! <span aria-hidden="true">&rarr;</span></a></li>
								  </ul>
								</nav>	
							</div>
						</div>
					</div>
	</div>


	<!--
		Expora!
		-->
	<form id = "form_subcorpora" action="" method="post" enctype="multipart/form-data">


					<!--
						Navigation For The SubCorpora Form
						-->
					<nav class = "text-center">
						<ul class="pagination">
							<li><a href="#" onclick = "goto(0)"><span class = "interface_sql_data_textdata_title">Exported Text Data</span></a></li>
							<li><a href="#" onclick = "goto(1)"><span class = "interface_sql_data_metadata_title">Exported Metadata</span></a></li>
							<li><a href="#" onclick = "goto(2)"><span class = "interface_sql_filters_title">Filters</span></a></li>
							<li><a href="#" onclick = "goto(3)"><span class = "interface_sql_sorting_title">Sorting</span></a></li>
							<li><a href="#" onclick = "goto(4)"><span class = "interface_pretreatments_title">Pretreatments</span></a></li>
							<li><a href="#" onclick = "goto(5)"><span class = "interface_format_title">File Format</span></a></li>
						</ul>
					</nav>


					<!--
						Exported Textdata Division
						-->
					<div class = "text-center options">
						<div id = "request_textdata">
							<h3 style = "margin:0em" class = "text-center"> - <span class = "interface_request_title">Request</span> - </h3>
							<div style = "padding-top: 0.5em; padding-bottom: 0.5em; margin: 0em"><h2 style = "margin:0em" id = "request_textdata_title"><span class = "interface_sql_data_textdata_choice">Choice of Exported Text Data</span></h2></div>
							
							<span id = "text_fields" style = "margin-top:0.2em">
									
										<!--AUTOMATIC GENERATION-->


							</span>
							<nav>
							  <ul class="pager">
							    <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
							    <li class="next" onclick = "goto(curr+1); work()"><a href="#"><span class = "interface_button_next">Next</span> <span aria-hidden="true">&rarr;</span></a></li>
							  </ul>
							</nav>
						</div>
					</div>



					<!--
						Exported Metadata Division
						-->
					<div class = "text-center options">
							<h3 style = "margin:0em" class = "text-center"> - <span class = "interface_request_title">Request</span> - </h3>
						<div id = "request_metadata" class = "col-md-6 col-md-offset-3" style = "transform: translateX(3em)">
							<div style = "padding-top: 0.5em; padding-bottom: 0.5em; margin: 0em"><h2 style = "margin:0em" id = "request_metadata_title"><span class = "interface_sql_data_metadata_choice">Choice of Exported Metadata</span>:</h2></div>
								<span id = "metadata_fields">
									
										<!--AUTOMATIC GENERATION-->
							
									</span>
							<nav>
							  <ul class="pager">
							    <li class="previous" onclick = "goto(curr-1)"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
							    <li class="next" onclick = "goto(curr+1)"><a href="#"><span class = "interface_button_next">Next</span> <span aria-hidden="true">&rarr;</span></a></li>
							  </ul>
							</nav>
						</div>
					</div>




					<!--
						Filters Division
						-->
					<div class = "text-center options">
							<h3 style = "margin:0em" class = "text-center"> - <span class = "interface_request_title">Request</span> - </h3>
							<div id = "request_filter">
								<h4 style = "padding: 0.5em; margin: 0em" id = "request_filter_title"><span class = "interface_sql_filters_title">Filters</span>:</h4>
								<div class = "text-center"><span class = "interaface_sql_filters_touse">Filter To Use</span>:</div>
								<table>

									<tr>
										<td>
											<select class="form-control" name="request_filter_type" id = "request_filter_type" onchange="changeFilter();">
				    	    					<option selected disabled style = "display: none;" value="interface_sql_filters_contains"><span class = "interface_sql_filters_contains">Filter To Use</span></option>
												<option id = "request_filter_type_interval"><span class = "interface_sql_filters_interval">Intervals</span></option>
												<option id = "interface_sql_filters_not_interval"><span class = "interface_sql_filters_not_interval">Out Of Intervals</span></option>
				    	   						<option value="request_filter_type_regular"><span class = "interface_sql_filters_regex">Regular Expressions</span></option>
				    	   						<option value="interface_sql_filters_not_regex"><span class = "interface_sql_filters_not_regex">Unlike Regular Expressions</span></option>
				    	    					<option value="request_filter_type_sql" ><span class = "interface_sql_filters_syntax">SQL syntax</span></option>
				    	    					<option value="request_filter_type_equals"><span class = "interface_sql_filters_equals">Equals</span></option>
				    	    					<option value="interface_sql_filters_not_equals"><span class = "interface_sql_filters_not_equals">NOT Equal To</span></option>
				    	    					<option value="interface_sql_filters_list"><span class = "interface_sql_filters_list">Items From List</span></option>
				    	    					<option value="interface_sql_filters_not_list"><span class = "interface_sql_filters_not_list">Items From "NOT List"</span></option>
				    	    					<option value="interface_sql_filters_starts"><span class = "interface_sql_filters_starts">Starts With</span></option>
				    	    					<option value="interface_sql_filters_ends"><span class = "interface_sql_filters_ends">Ends With</span></option>
				    	    					<option value="interface_sql_filters_contains"><span class = "interface_sql_filters_contains">Contains</span></option>
				    						</select>
										</td>
										<td>
											<select class="form-control" name="request_filter_field" id = "request_filter_field" style = "max-width:25em;">
												<option selected disabled style = "display: none;" id = "request_filter_field_title">Field To Use</span></span></option>
				    						</select>
										</td>
										<td>
											<input class="form-control" type = "text" name = "request_filter_value" id = "request_filter_value" onkeyup = "dynamicLoad()" placeholder = "Field Value"/>
											<div id = "request_filter_interval_inputs" style = "display:none">
												<span class = "interface_sql_filters_min">Min Value</span>:
												<input class="form-control" type = "text" name = "request_filter_interval_min" id = "request_filter_interval_min" onkeyup = "dynamicLoad()" size = 5 /><br>
												<span class = "interface_sql_filters_max">Max Value</span>:
												<input class="form-control" type = "text" name = "request_filter_interval_max" id = "request_filter_interval_max" onkeyup = "dynamicLoad()" size = 5 />
											</div>
											<div id = "request_filter_not_interval_inputs" style = "display:none">
												<span class = "interface_sql_filters_greaterthan">Greater Than</span>:
												<input class="form-control" type = "text" name = "request_filter_interval_greaterthan" id = "request_filter_interval_greaterthan" onkeyup = "dynamicLoad()" size = 5 /><br>
												<span class = "interface_sql_filters_lessthan">Less Than</span>:
												<input class="form-control" type = "text" name = "request_filter_interval_lessthan" id = "request_filter_interval_lessthan" onkeyup = "dynamicLoad()" size = 5 />
											</div>
										</td>	
										<td>
											<div id = "request_filter_add" onclick = "showANDOR()">
												<center>+</center>
											</div>
											<div id = "request_filter_add_new">
												<div id = "request_filter_add_and"  onclick = "addFilter('AND')"><span style = "padding:0.2em; border:0.08em solid #555555; border-radius:20%;" class = "interface_sql_filters_and">AND</span></div>&nbsp;
												<div id = "request_filter_add_or"  onclick = "addFilter('OR')"><span style = "padding:0.2em; border:0.08em solid #555555; border-radius:20%;" class = "interface_sql_filters_or">OR</span></div>
											</div>
										</td>				
									</tr>
								</table>
								<br>
								Your Filter Is Shown Below(you can also edit it):
								<br>
								<div class="input-group col-md-10 col-md-offset-1" style = "margin-bottom:0.2em">
				  					<textarea class="form-control col-md-8" rows="3" id = "request_filter_finalvalue" onkeyup = "editFilter()" placeholder="Edit Filter Here .."></textarea>
								</div>
								<nav>
								  <ul class="pager">
								    <li class="previous" onclick = "goto(curr-1)"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
								    <li class="next" onclick = "goto(curr+1)"><a href="#"><span class = "interface_button_next">Next</span> <span aria-hidden="true">&rarr;</span></a></li>
								  </ul>
								</nav>	
							</div>
						</div>



						<!--
							Sorting Division
							-->
						<div class = "text-center options">
							<h3 style = "margin:0em" class = "text-center"> - <span class = "interface_request_title">Request</span> - </h3>
							<div id = "request_sort">
								<h4 style = "padding: 0.5em; margin: 0em" id = "request_sort_title"><span class = "interface_sql_sorting_title">Sorting</span>:</h4>
								<table>
									<tr>
										<td>
											<select class="form-control" name="request_sort_field" id = "request_sort_field" style = "max-width:25em;">
												<option selected disabled style = "display: none;" id = "request_sort_field_title"><span class = "interface_sql_sorting_title">Field To Use For Sorting</span>:</option>
				    						</select>
										</td>
										<td>
											<select class="form-control" name="request_sort_type" id = "request_sort_type">
												<option selected disabled style = "display: none" id = "request_sort_type_title"><span class = "interface_sql_sorting_type">Sorting Type</span></option>
				    	   						<option value="ASC" id = "request_sort_type_asc"><span class = "interface_sql_sorting_asc">Ascending</span></option>
				    	    					<option value="DESC" id = "request_sort_type_desc"><span class = "interface_sql_sorting_desc">Descending</span></option>
				    						</select>
										</td>
									</tr>
								</table>
							<nav>
							  <ul class="pager">
							    <li class="previous" onclick = "goto(curr-1)"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
							    <li class="next" onclick = "goto(curr+1)"><a href="#"><span class = "interface_button_next">Next</span> <span aria-hidden="true">&rarr;</span></a></li>
							  </ul>
							</nav>	
							</div>
						</div>




						<!--
							Pretreatments Division
							-->
						<div class = "text-center options">
							<div id = "output_pretreatments">
								<h3 style = "margin:0em" class = "text-center"> - <span class = "interface_output_title">Output</span> - </h3>
								<h4 style = "padding: 0.5em; margin: 0em" id = "output_pretreatments_title">Pretreatments</span>:</h4>
								<table>
									<tr>
										<td>
											<label><input type="checkbox" name="output_pretreatments_lowercase" /> <div class = "output_pretreatments_lowercase" style = "display: inline-block"><span class = "interface_pretreatments_lowercase">All Lowercase</span></div></label>
										</td>			
									</tr>
									<tr>
										<td>
											<label><input type="checkbox" name="output_pretreatments_replace_smileys" /> <div class = "output_pretreatments_replace_smileys" style = "display: inline-block"><span class = "interface_pretreatments_smileys">Replacement of Smileys</span></div>
											<ul style = "list-style-type: none;">
												<li>
													<label><input type="radio" name = "output_pretreatments_replace_smileys_options" class="output_pretreatments_replace_smileys_name" /> <div style = "display: inline-block"><span class = "interface_pretreatments_smileys_name">Replace By Name</span></div></label>
												</li>
												<li>

													<label><input type="radio" name = "output_pretreatments_replace_smileys_options" class="output_pretreatments_replace_smileys_cat" /> <div style = "display: inline-block"><span class = "interface_pretreatments_smileys_name">Replace By Meaning</span></div></label>
												</li>
												<li>
													<label><input type="radio" name = "output_pretreatments_replace_smileys_options" class="output_pretreatments_replace_smileys_meaning" /> <div style = "display: inline-block"><span class = "interface_pretreatments_smileys_name">Replace By Category</span></div></label>
												</li>
												<li>
													<label><input type="radio" name = "output_pretreatments_replace_smileys_options" class="output_pretreatments_replace_smileys_type" /> <div style = "display: inline-block"><span class = "interface_pretreatments_smileys_name">Replace By Type</span></div></label>
												</li>
												</label>
											</ul>
										</td>
									</tr>				
									<tr>
										<td>
										
											<div class="input-group" style = "margin:0em; padding:0.1em">
										      <span class="input-group-addon" style = "transform:translateX(-1em)">
										        <input type="checkbox" class = "output_pretreatments_find_replace" aria-label="Use Find And Replacement">
										      </span>
												<span class = "text-center" id = "output_pretreatments_find_replace_file_zeroth_value" style = "display:block" style = "transform:translateX(-1em)"></span>
								
												<label class="form-control btn btn-primary btn-file" for="output_pretreatments_find_replace_file_zeroth" style = "transform:translateX(-1em)">
												    <input id="output_pretreatments_find_replace_file_zeroth" name = "output_pretreatments_find_replace_file_zeroth" type="file" style="display:none;" onchange="if($(this).val() != ''){$('#output_pretreatments_find_replace_file_zeroth_value').html('File: '.concat($(this).val()));}">
												    <span class = "interface_pretreatments_findreplace">Find / Replace from a File</span>
												</label>
										    </div>
										</td>
									</tr>
								</table>
								<nav>
								  <ul class="pager">
								    <li class="previous" onclick = "goto(curr-1)"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
								    <li class="next" onclick = "goto(curr+1)"><a href="#"><span class = "interface_button_next">Next</span> <span aria-hidden="true">&rarr;</span></a></li>
								  </ul>
								</nav>	
							</div>
						</div>




						<!--
							Output Format Division
							-->
						<div class = "text-center options">
							<div id = "output_format" class = "options">
								<h3 style = "margin:0em" class = "text-center"> - <span class = "interface_output_title">Output</span> - </h3>
								<h4 style = "padding: 0.5em; margin: 0em" id = "output_format_title"><span class = "interface_format_title">File Format</span>:</h4>
								<table>
									<tr>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="output_format_txm" id = "output_format_txm_radio"><div id = "output_format_txm" style = "display: inline-block">TextObserver / TXM</div></label>
											</div>
										</td>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="output_format_treecloud" id = "output_format_treecloud_radio"><div id = "output_format_treecloud" style = "display: inline-block">TreeCloud</div></label>
											</div>
										</td>					
									</tr>
									<tr>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="output_format_alceste" id = "output_format_alceste_radio"><div id = "output_format_alceste" style = "display: inline-block">Alceste</div></label>
											</div>
										</td>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="output_format_lexico" id = "output_format_lexico_radio"><div id = "output_format_lexico" style = "display: inline-block">Lexico</div></label>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="output_format_csv" id = "output_format_csv_radio"><div id = "output_format_csv" style = "display: inline-block">CSV</div></label>
											</div>
										</td>

										<td>
											<div class="checkbox" style = "margin:0em; padding:0.1em">
												<label><input type="checkbox" name="output_format" value="output_format_html" id = "output_format_html_radio"><div id = "output_format_html" style = "display: inline-block">HTML</div></label>
											</div>
											
										</td>
									</tr>
									<tr><td colspan = 2>
											<div class="input-group" style = "margin:0em; padding:0.1em">
										      <span class="input-group-addon" style = "transform:translateX(-1em)">
										        <input type="checkbox" id = "output_format_xsl_radio" aria-label="Use XSLT File">
										      </span>
												<span class = "text-center" id="upload-file-info" style = "display:block" style = "transform:translateX(-1em)"></span>
								
												<label class="form-control btn btn-primary btn-file" for="output_format_xsl_file" style = "transform:translateX(-1em)">
												    <input id="output_format_xsl_file" name = "output_format_xsl_file" type="file" style="display:none;" onchange="if($(this).val() != ''){$('#upload-file-info').html('File: '.concat($(this).val()));}">
												    <span class = "interface_sql_output_xsl">Upload XSL File and use XSL transformations</span>
												</label>
										    </div>
									</td></tr>
								</table>
					
								<h5>
									<div class="checkbox" style = "margin:0em; padding:0.1em">
										<label><input type="checkbox" onclick = "addShared()"><div style = "display: inline-block"><span class = "interace_sql_output_favourites">Share this query with others</span>!</div></label>
									</div>
									<div class="checkbox" style = "margin:0em; padding:0.1em">
										<label><input type="checkbox" onclick = "addFavourite()"><div style = "display: inline-block"><span class = "interface_sql_output_favourites">Add to favourites</span>!</div></label>
									</div>
									<input type="text" class = "output_query_name form-control" placeholder="Name Your Query (Not Compulsory)" aria-describedby="basic-addon1">
									
								</h5>
								<nav>
								  <ul class="pager">
								    <li class="previous" onclick = "goto(curr-1)"><a href="#"><span aria-hidden="true">&larr;</span> <span class = "interface_button_previous">Previous</span></a></li>
								    <li class="next" onclick = "buildQuery()" id = "submit_form" name = "submit_form"><a href="#"><span class = "interface_button_export">EXPORT</span>! <span aria-hidden="true">&rarr;</span></a></li>
								  </ul>
								</nav>	
							</div>
						</div>
					</div>

	</form>

	<!--
		Metadata!
		-->
	<div id = "form_metadata">


		<!--
			Navigation Bar For Metadata
			-->
		<nav class = "text-center" style = "margin-bottom:0em">
			<ul class="pagination">
				<li><a href="#" onclick = "metadata_goto(0)"><span class = "interface_metadata_csv">Update Using CSV</span></a></li>
				<li><a href="#" onclick = "metadata_goto(1)"><span class = "interface_metadata_add_medatata">Add Metadata</span></a></li>
				<li><a href="#" onclick = "metadata_goto(2)"><span class = "interface_metadata_primary">Primary Keys</span></a></li>
			</ul>
		</nav>

		<!--
			File Uploading For Metadata
			-->
		<div class = "metadata_box">
			<form class = "form" action = "" method = "post" enctype="multipart/form-data">

					<h3 class = "text-center" style = "margin-top:0em">- <span class = "interface_metadata_upload_title">Upload A CSV</span> -</h3>
					<br>
						<h5 class = "text-center"><span class = "interface_metadata_csv_descp">Upload a CSV in the proper format(as given in the 'add metadata' option)</span>:</h5>
						<label class="btn btn-primary btn-file col-md-4 col-md-offset-4" for="metadata_box_file">
						    <input id="metadata_box_file" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
						    <span class = "interface_metadata_csv_choose">Choose CSV</span>
						</label>
						<br>
						<span class='label label-info col-md-4 col-md-offset-4' id="upload-file-info"></span>
							<br>
							<br>
						<center>
							<input type = "button" class = "btn btn-default btn-file col-md-2 col-md-offset-5" value = "Update" onclick = "uploadMetadataCSV()" class="btn btn-default">
						</center>
			</form>
			<br>
			<div class = "form_metadata_output col-md-4 col-md-offset-4 text-center" style= "font-size:1.4em">
				
			</div>
			<br><br>
		</div>

		<!--
			This gets the input from the user in a textarea (for Metadata)
			-->
		<div class = "metadata_box">
			<form class = "form" action = "" method = "post">

					<h3 class = "text-center" style = "margin-top:0em">- <span class = "interface_toolbar_metadata">Add Metadata</span></span> -</h3>
					<br>
						<div class="input-group col-md-10 col-md-offset-1" style = "margin-bottom:0.2em">
		  					<textarea class="form-control col-md-8" rows="10" id = "form_metadata_input" placeholder="_"></textarea>
						</div>
							<br>
						<center>
							<input type = "button" value = "Update" onclick = "updateMetadata()" class="btn btn-default">
						</center>
			</form>
			<br>
			<div class = "form_metadata_output col-md-4 col-md-offset-4 text-center" style= "font-size:1.4em">
				
			</div>
			<br><br>
		</div>


		<!--
			This div shows primary keys of the tables which are used.
			-->
		<div id = "form_metadata_primary_keys" class = "metadata_box col-md-4 col-md-offset-4">
			<h3 class = "text-center" style= "margin-top:0em">- <span id = "interface_metadata_primary">Primary Keys</span></span> -</h3>
				<br />
				<h5><span class = "interface_metadata_primary_desc_one">Following are the primary keys of the tables in the database. Use them to add the metadata!</span></h5>

				<h5>
					<ul id = "form_metadata_primary_keys_value">
					</ul>
				</h5>
				<br>
				<h5><b><span class = "interface_metadata_primary_note">Note</span>:</b> <span class = "interface_metadata_primary_desc_two">For the insertion of metadata, every item/cell is stored in "double quotes" and is separated with semi-colons, which is showed in the example in 'Add Metadata' default text.</span></h5>
		</div>

	</div>

	<div id = "form_history">
		<h1 style = "margin-left:1em"><span class = "interface_log_history_title">History</span></h1>
		<h5 style = "margin-left:2.7em; margin-right:2.7em;"><span class = "interface_log_history_desc">Here are all SQL Queries that you have used so far(if your query is not visible, then please refresh the page)</span>:</h5>
		<div style = "width:100%; padding-top:1%; padding-left:5%; padding-right:5%; padding-bottom:2%">	
			<table id = "form_history_table" class="table table-striped table-bordered" cellspacing="0">

			</table>
		</div>
	</div>


	<div id = "form_shared">
		<h1 style = "margin-left:1em"><span class = "interface_log_shared_title">Shared Queries</span></h1>
		<h5 style = "margin-left:2.7em; margin-right:2.7em;"><span class = "interface_log_shared_desc">Here are all the Queries shared by other users(if your query is not visible, then please refresh the page)</span>:</h5>
		<div style = "width:100%; padding-top:1%; padding-left:5%; padding-right:5%; padding-bottom:2%">	
			<table id = "form_shared_table" class="table table-striped table-bordered" cellspacing="0">
			</table>
		</div>
	</div>


	<!--
		This div will show the ouput of the running queries.
		-->

	<div id = "query_result">
			<!--
				Navigation Bar For Metadata
				-->
			<nav class = "text-center" style = "margin-bottom:0em; margin-top:0em">
				<ul class="pagination">
					<li><a href="#" onclick = "alert('Under Construction!')"><span class = "">Output</span></a></li>
					<li><a href="#" onclick = "alert('Under Construction!')"><span class = "">Text Visualizations</span></a></li>
					<li><a href="#" onclick = "alert('Under Construction!')"><span class = "">Other Visualizations</span></a></li>
				</ul>
			</nav>

		<div id = "output_container" style = "overflow:auto">




		</div>
	</div>

	<div id = "loader">
		<br><br><br><br><br><br><br><br><br><br>
		<div id = "loaderDiv">
			<h1 id = "loaderText" class = "text-center">Please Wait.</h1>
			<div class="cssload-thecube">
				<div class="cssload-cube cssload-c1"></div>
				<div class="cssload-cube cssload-c2"></div>
				<div class="cssload-cube cssload-c4"></div>
				<div class="cssload-cube cssload-c3"></div>
			</div>
		</div>
	</div>

	<!--
		Include The Script Files
		-->
	<script src="js/jquery.min.js"></script>
	<script type = "text/javascript" src = "js/index.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
<!--	<script type="text/javascript" src="http://l2.io/ip.js?var=hostip"></script>-->
	<script src="js/bootstrap-select.min.js"></script>


</body>
</html>