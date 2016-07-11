// Create a Global Variable For Query
var query = "SELECT ";

var favourite = 0;

var shared = 0;

var hostip = "No Internet";


// All the files to be downloaded will be shown in this Unordered list.
var files = document.getElementById("query_result_downloads_ul");

// Is Replacement of Smileys needed? false is default.
var r_smileys = "false";
var r_type = false;

var about = document.getElementsByClassName("about_options");

// Is Lowercase to be done?
var lowercase = "false";

// Is Find Replace of Text to be done?
var findreplace = "false";

// Query Name
var query_name = "";

// This variable is a array of table names which are used for the sql query.
var tables_used = [];

// Create a Global Variable For Filters
var filter = "";
	
//Language variable
var language = "EN";

// This Variable will be used to switch between the Metadata, like Add Metadata, Use CSV, Primary Keys.
var f =  document.getElementsByClassName("metadata_box");

// This Variable will be used to switch between the Expora Options, like Exported Text Data, Exported Metadata etc.
var e = document.getElementsByClassName("options");

// This Variable will be used to switch between the SQL Query options.
var q = document.getElementsByClassName("sql_options");

// Adds table to tables_used variable
function addTable(table)
{
	var flag = false;
	var i = 0;

	// If exists then set flag to true.
	for(i = 0; i < tables_used.length; i++)
	{
		if(tables_used[i] == table)
		{
			flag = true;
			break;
		}
	}
	if(!flag)
	{
		tables_used.push(table);
	}

}

// Function to display the loader animation
function Loader(toLoad)
{
	if(toLoad)
	{
		document.getElementById("loader").style.display = "block";
	}
	else{
		document.getElementById("loader").style.display = "none";
	}
}

// Function to Build The Query
function buildQuery()
{
	document.getElementById("query_result_downloads_ul").innerHTML = "";

	Loader(true);
	document.getElementById("form_metadata").style.display = "none";
	document.getElementById("form_subcorpora").style.display = "none";
	document.getElementById("form_sqlquery").style.display = "none";
	document.getElementById("language").style.display = "none";
	filter = document.getElementById("request_filter_finalvalue").value;
	// Variable for the Columns To Be Retrieved. SELECT ________ FROM ..
	var columns = "";

	// Variable for the tables to be used. SELECT columns FROM ________
	var from = "";
	
	var where = "";

	query_name = document.getElementsByClassName("output_query_name")[1].value;
	
	var i = 0;
	
	var textdata = document.getElementsByName("textdata_checkbox");
	
	// Empty The Tables Used
	tables_used = [];
	for(i = 0; i < textdata.length; i++)
	{
		if(textdata[i].checked)
		{
			columns = columns.concat(", ".concat((textdata[i].id).replace("__",".")));
			addTable(((textdata[i].id).replace("__",";")).substr(0, ((textdata[i].id).replace("__",";")).indexOf(';')));
		}
	}

	var metadata = document.getElementsByName("metadata_checkbox");
	for(i = 0; i < metadata.length; i++)
	{
		if(metadata[i].checked)
		{
			columns = columns.concat(", ".concat((metadata[i].id).replace("__",".")));
			addTable(((metadata[i].id).replace("__",";")).substr(0, ((metadata[i].id).replace("__",";")).indexOf(';')));
		}
	}
	columns = columns.substring(2);


	if(tables_used.length == 0)
	{
		alert("Please Select At Least One Field To Export");
		shared = 0;
		favourite = 0;
		return;
	}

	if(document.getElementsByName("output_pretreatments_replace_smileys")[1].checked == true)
	{
		r_smileys = "true";
		if(document.getElementsByClassName("output_pretreatments_replace_smileys_name")[1].checked == true)
		{
			r_type = "mm_";
		}
		if(document.getElementsByClassName("output_pretreatments_replace_smileys_meaning")[1].checked == true)
		{
			r_type = "mmc_";
		}
		if(document.getElementsByClassName("output_pretreatments_replace_smileys_cat")[1].checked == true)
		{
			r_type = "mmm_";
		}
		if(document.getElementsByClassName("output_pretreatments_replace_smileys_type")[1].checked == true)
		{
			r_type = "mmt_";
		}

	}

	if(document.getElementsByClassName("output_pretreatments_find_replace")[1].checked == true)
	{
		findreplace = "true";

		var file_data = $('#output_pretreatments_find_replace_file_zeroth').prop('files')[0];   
		var form_data = new FormData();
		form_data.append('file', file_data);
		$.ajax(
			{
				url: 'php/findReplaceWords.php', // point to server-side PHP script 
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data:form_data,
				type: 'POST',
				success: function(result)
				{
				},
				complete: function()
				{

				}
			}
		);
	}

	if(document.getElementsByName("output_pretreatments_lowercase")[1].checked == true)
	{
		lowercase = "true";
	}

	//CREATE FROM FOR TWO TABLES.
	$.ajax(
	{
		url:"php/createFrom.php", //the page containing php script
		type: "POST", //request type
		data:{length: tables_used.length, tableOne: tables_used[0]},
		success:function(result)
		{
			from = result;

			/*Sorting Input*/
		    var request_sort_field = document.getElementById("request_sort_field");
		 	var request_sort_type = document.getElementById("request_sort_type");
		    var ordering = false;
		    var order_field;
		    var order_type;
		    if(request_sort_field.selectedIndex == 0)
		    {
		    	ordering = false;
		    }
		    else
		    {
		    	ordering = true;
		    	order_field = request_sort_field.options[request_sort_field.selectedIndex].value;
		    	order_type = request_sort_type.options[request_sort_type.selectedIndex].value
		    	if(request_sort_type.selectedIndex == 0)
		    		order_type = "ASC";
		    }


		  	/*Building The Query*/
			if(where != "" && filter != "")
			{
				where = where.concat(" AND ").concat(filter);
			}
			else if(where != "" || filter != "")
			{
				where = where.concat(filter);
			}
			if(where != "")
			{
				if(ordering == true)
					query = query.concat(columns).concat(" FROM ").concat(from).concat(" WHERE ").concat(where).concat(" ORDER BY ").concat(order_field).concat(" ").concat(order_type);
				else
					query = query.concat(columns).concat(" FROM ").concat(from).concat(" WHERE ").concat(where);
			}
			else
			{
				if(ordering == true)
					query = query.concat(columns).concat(" FROM ").concat(from).concat(" ORDER BY ").concat(order_field).concat(" ").concat(order_type);
				else
					query = query.concat(columns).concat(" FROM ").concat(from);
			}

			/*Executing the Query*/
			$.ajax(
				{
					url:"php/executeQuery.php", //the page containing php script
					type: "POST", //request type
					data:{ query: query, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
					success:function(result)
					{
						/*Creating the output*/
						/*document.getElementById("form_metadata").style.display = "none";
						document.getElementById("form_subcorpora").style.display = "none";
						document.getElementById("form_sqlquery").style.display = "none";
						document.getElementById("language").style.display = "none";*/
						document.getElementById("query_result").style.display = "block";
						document.getElementById("output_container").innerHTML = result;
					},
	  	complete: function(){
					Loader(false);}
				}
			);

			/*Log The User*/
			$.ajax(
				{
					url:"php/log.php", //the page containing php script
					type: "POST", //request type
					data:{ query: query, hostip: hostip, shared: shared, favourite: favourite, lowercase:lowercase, query_name: query_name}, // Passing the query to a variable named 'query' in executeQuery	
					success:function(result)
					{
					}
				}
			);

			/*File Format*/
			var file_format_selected = false;
			if(document.getElementById('output_format_txm_radio').checked) 
			{
				file_format_selected = true;
				// Create TXM Output
				$.ajax(
					{
						url:"php/output_format_txm.php", //the page containing php script
						type: "POST", //request type
						data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
						success:function(result)
						{
							document.getElementById("download_file").href = "downloads/".concat(result); 
							document.getElementById("download_file").download = result;
							document.getElementById('download_file').click();
														
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>TextObserver file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>TextObserver file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
						},
	  	complete: function(){
	  					// Disable the laoder Animation
						Loader(false);
					}
					}
				);
		 	}
		 	// Create TreeCloud Output
			if(document.getElementById('output_format_treecloud_radio').checked)
			{
				file_format_selected = true;
				$.ajax(
					{
						url:"php/output_format_treecloud.php", //the page containing php script
						type: "POST", //request type
						data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
						success:function(result)
						{
							document.getElementById("download_file").href = "downloads/".concat(result); 
							document.getElementById("download_file").download = result;
							document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>TreeCloud file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>TreeClouD file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
						},
	  	complete: function(){
					Loader(false);
					
			}
					}
				);
		  	}
		  	// Create Alceste Output
			if(document.getElementById('output_format_alceste_radio').checked)
			{
				file_format_selected = true;
				$.ajax(
					{
						url:"php/output_format_alceste.php", //the page containing php script
						type: "POST", //request type
						data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
						success:function(result)
						{
							document.getElementById("download_file").href = "downloads/".concat(result); 
							document.getElementById("download_file").download = result;
							document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>Alceste file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>Alceste file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
						},
	  	complete: function(){
					Loader(false);

				}
					}
				);
		  	}
		  	// Create Lexico Output
			if(document.getElementById('output_format_lexico_radio').checked)
			{
				file_format_selected = true;
				$.ajax(
					{
						url:"php/output_format_lexico.php", //the page containing php script
						type: "POST", //request type
						data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
						success:function(result)
						{
							document.getElementById("download_file").href = "downloads/".concat(result); 
							document.getElementById("download_file").download = result;
							document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>Lexico file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>Lexico file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
						},
	  	complete: function(){
					Loader(false);

				}
					}
				);
		  	}
		  	// Create CSV output
			if(document.getElementById('output_format_csv_radio').checked)
			{
				file_format_selected = true;
				$.ajax(
					{
						url:"php/output_format_csv.php", //the page containing php script
						type: "POST", //request type
						data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
						success:function(result)
						{
							document.getElementById("download_file").href = "downloads/".concat(result); 
							document.getElementById("download_file").download = result;
							document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>CSV file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>CSV file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
						},
	  	complete: function(){
					Loader(false);

				}
					}
				);
		  	}
		  	// Create HTML Output
			if(document.getElementById('output_format_html_radio').checked)
			{
				file_format_selected = true;
				$.ajax(
					{
						url:"php/output_format_html.php", //the page containing php script
						type: "POST", //request type
						data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
						success:function(result)
						{
							document.getElementById("download_file").href = "downloads/".concat(result); 
							document.getElementById("download_file").download = result;
							document.getElementById('download_file').click();
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>HTML file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>HTML file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}
		   			    	$(output).appendTo("#query_result_downloads_ul");	
						},
	  	complete: function(){
					Loader(false);

				}
					}
				);
		  	}

		  	// THIS NEEDS TO BE UPDATED!
			if(document.getElementById('output_format_xsl_radio').checked)
			{
				file_format_selected = true;
					$.ajax(
						{
							url:"php/output_format_txm.php", //the page containing php script
							type: "POST", //request type
							data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
							success:function(result)
							{
								var filename = result;
								var xsl_filename = (filename.substr(0, filename.lastIndexOf('.'))).concat(".xsl");
								var file_data = $('#output_format_xsl_file').prop('files')[0];   
								var form_data = new FormData();
								form_data.append('xsl_file', file_data);
								form_data.append('xsl_filename', xsl_filename);
								form_data.append('filename', filename);
								$.ajax(
									{
										url: 'php/output_format_xsl.php', // point to server-side PHP script 
										dataType: 'text',
										cache: false,
										contentType: false,
										processData: false,
										data:form_data,
										type: 'POST',
										success: function(xsl_result)
										{
											/*Creating the output*/
											document.getElementById("form_metadata").style.display = "none";
											document.getElementById("form_subcorpora").style.display = "none";
											document.getElementById("form_sqlquery").style.display = "none";
											document.getElementById("language").style.display = "none";
											document.getElementById("query_result").style.display = "block";
											document.getElementById("output_container").innerHTML = xsl_result;
										},
	  	complete: function(){
					Loader(false);
				}
									}
								);
							}
						}
					);
		  	}
		  	// If no File Format Is Selected, Then Alert The User*/
		  	if(file_format_selected == false)
		  	{
		  		if(language == "EN")
			  		alert("Note: No Output Format Selected");
			  	else
			  		alert("Remarque: Non format de sortie sélectionné");
		  	}
		},
	  	complete: function(){
					query = "SELECT ";
					favourite = 0;
					shared = 0;

					// Is Replacement of Smileys needed? false is default.
					r_smileys = "false";
					r_type = false;

					// Is Lowercase to be done?
					lowercase = "false";

	  	}
	}
	);


}

// Change Language .. Needs to be improved!
function changeLang(lang)
{
	language = lang;

	$.ajax(
		{
			url:"php/translate.php", //the page containing php script
			type: "POST", //request type
			data:{lang:lang}, // Passing the query to a variable named 'query' in executeQuery	
			success:function(result)
			{
				var lines = result.split("##"); 
				for(var i = 1; i < lines.length; i++)
				{
					var infos = lines[i].split("|");
					var id = infos[0];
					var description = infos[1];
					var elements = document.getElementsByClassName(id);
					for(var j = 0; j < elements.length; j++)
					{
						elements[j].innerHTML = description;
					}
				}
			}
		}
	);


	document.getElementById("text_fields").innerHTML = "";
	document.getElementById("metadata_fields").innerHTML = "";
	loadTextFields();
	loadMetadataFields();
}


// Switch to use the SQL Query
function switch_about()
{
	document.getElementById("query_result").style.display = "none";
	document.getElementById("form_metadata").style.display = "none";
	document.getElementById("expora_about").style.display = "block";
	document.getElementById("form_history").style.display = "none";
	document.getElementById("form_shared").style.display = "none";
	document.getElementById("form_subcorpora").style.display = "none";
	document.getElementById("form_sqlquery").style.display = "none";
}
// Switch to use the SQL Query
function switch_sqlquery()
{
	document.getElementById("query_result").style.display = "none";
	document.getElementById("form_metadata").style.display = "none";
	document.getElementById("expora_about").style.display = "none";
	document.getElementById("form_history").style.display = "none";
	document.getElementById("form_shared").style.display = "none";
	document.getElementById("form_subcorpora").style.display = "none";
	document.getElementById("form_sqlquery").style.display = "block";
}

// Switch to use the SubCorpora App
function switch_subcorpora()
{
	document.getElementById("query_result").style.display = "none";
	document.getElementById("form_metadata").style.display = "none";
	document.getElementById("form_history").style.display = "none";
	document.getElementById("form_shared").style.display = "none";
	document.getElementById("form_sqlquery").style.display = "none";
	document.getElementById("expora_about").style.display = "none";
	document.getElementById("form_subcorpora").style.display = "block";
}

// Switch to use "add metadata"
function switch_metadata()
{
	document.getElementById("query_result").style.display = "none";
	document.getElementById("form_history").style.display = "none";
	document.getElementById("form_shared").style.display = "none";
	document.getElementById("form_subcorpora").style.display = "none";
	document.getElementById("form_sqlquery").style.display = "none";
	document.getElementById("expora_about").style.display = "none";
	document.getElementById("form_metadata").style.display = "block";
}

// Switch to use "History"
function switch_history()
{
	document.getElementById("query_result").style.display = "none";
	document.getElementById("form_shared").style.display = "none";
	document.getElementById("form_metadata").style.display = "none";
	document.getElementById("form_subcorpora").style.display = "none";
	document.getElementById("expora_about").style.display = "none";
	document.getElementById("form_sqlquery").style.display = "none";
	document.getElementById("form_history").style.display = "block";
}

// Switch to use "Shared Queries"
function switch_shared()
{
	document.getElementById("query_result").style.display = "none";
	document.getElementById("form_history").style.display = "none";
	document.getElementById("form_metadata").style.display = "none";
	document.getElementById("form_subcorpora").style.display = "none";
	document.getElementById("form_sqlquery").style.display = "none";
	document.getElementById("form_shared").style.display = "block";
	document.getElementById("expora_about").style.display = "none";
}

// Running the query if SQL Query is used (NOT for SubCorpora App)
function runQuery()
{
	document.getElementById("query_result_downloads_ul").innerHTML  = "";

	Loader(true);
	document.getElementById("form_metadata").style.display = "none";
	document.getElementById("form_subcorpora").style.display = "none";
	document.getElementById("form_sqlquery").style.display = "none";
	document.getElementById("language").style.display = "none";
	var file_format_selected = false;

	query_name = document.getElementsByClassName("output_query_name")[0].value;

	var query;
	if(document.getElementById("sql_query_form_input_where").value != "")
		query = "SELECT ".concat(document.getElementById("sql_query_form_input_select").value).concat(" FROM ").concat(document.getElementById("sql_query_form_input_from").value).concat(" WHERE ").concat(document.getElementById("sql_query_form_input_where").value);
	else
		query = "SELECT ".concat(document.getElementById("sql_query_form_input_select").value).concat(" FROM ").concat(document.getElementById("sql_query_form_input_from").value);
	if(document.getElementById("sql_query_form_input_order").value != "")
		query = query.concat(" ORDER BY ").concat(document.getElementById("sql_query_form_input_order").value);

	if(document.getElementsByName("output_pretreatments_replace_smileys")[0].checked == true)
	{
		r_smileys = "true";
		if(document.getElementsByClassName("output_pretreatments_replace_smileys_name")[0].checked == true)
		{
			r_type = "mm_";
		}
		if(document.getElementsByClassName("output_pretreatments_replace_smileys_meaning")[0].checked == true)
		{
			r_type = "mmc_";
		}
		if(document.getElementsByClassName("output_pretreatments_replace_smileys_cat")[0].checked == true)
		{
			r_type = "mmm_";
		}
		if(document.getElementsByClassName("output_pretreatments_replace_smileys_type")[0].checked == true)
		{
			r_type = "mmt_";
		}
	}

	if(document.getElementsByName("output_pretreatments_lowercase")[0].checked == true)
	{
		lowercase = "true";
	}


	if(document.getElementsByClassName("output_pretreatments_find_replace")[0].checked == true)
	{
		findreplace = "true";
		var file_data = $('#output_pretreatments_find_replace_file_first').prop('files')[0];   
		var form_data = new FormData();
		form_data.append('file', file_data);
		$.ajax(
			{
				url: 'php/findReplaceWords.php', // point to server-side PHP script 
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data:form_data,
				type: 'POST',
				success: function(result)
				{
				},
				complete: function()
				{

				}
			}
		);
	}
	
	/*Executing the Query*/
	$.ajax(
		{
			url:"php/executeQuery.php", //the page containing php script
			type: "POST", //request type
			data:{ query: query, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
			success:function(result)
			{
				if(result == "")
					alert("File Created Successfully!");
				else
					alert(result);
					},
	  	complete: function(){
					Loader(false);
				}
				
		}
	);

	/*Log The User*/
	$.ajax(
		{
			url:"php/log.php", //the page containing php script
			type: "POST", //request type
			data:{ query: query, hostip: hostip, shared: shared, favourite: favourite, query_name: query_name}, // Passing the query to a variable named 'query' in executeQuery	
			success:function(result)
			{
			}
		}
	);

	/*File Format*/
	var file_format_selected = false;
	// Create TXM Output
	if(document.getElementById('sql_output_format_txm_radio').checked) 
	{
		file_format_selected = true;
		$.ajax(
			{
				url:"php/output_format_txm.php", //the page containing php script
				type: "POST", //request type
				data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
				success:function(result)
				{
					document.getElementById("download_file").href = "downloads/".concat(result); 
					document.getElementById("download_file").download = result;
					document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>TextObserver file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>TextObserver file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
				}
			}
		);
 	}
 	// Create TreeCloud Output
	if(document.getElementById('sql_output_format_treecloud_radio').checked)
	{
		file_format_selected = true;
		$.ajax(
			{
				url:"php/output_format_treecloud.php", //the page containing php script
				type: "POST", //request type
				data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
				success:function(result)
				{
					document.getElementById("download_file").href = "downloads/".concat(result); 
					document.getElementById("download_file").download = result;
					document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>TreeCloud file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>TreeCloud file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
				}
			}
		);
  	}
  	// Create Alceste output
	if(document.getElementById('sql_output_format_alceste_radio').checked)
	{
		file_format_selected = true;
		$.ajax(
			{
				url:"php/output_format_alceste.php", //the page containing php script
				type: "POST", //request type
				data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
				success:function(result)
				{
					document.getElementById("download_file").href = "downloads/".concat(result); 
					document.getElementById("download_file").download = result;
					document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>Alceste file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>Alceste file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
				}
			}
		);
  	}
  	// Create Lexico output
	if(document.getElementById('sql_output_format_lexico_radio').checked)
	{
		file_format_selected = true;
		$.ajax(
			{
				url:"php/output_format_lexico.php", //the page containing php script
				type: "POST", //request type
				data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
				success:function(result)
				{
					document.getElementById("download_file").href = "downloads/".concat(result); 
					document.getElementById("download_file").download = result;
					document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>Lexico file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>Lexico file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}
		   			    	$(output).appendTo("#query_result_downloads_ul");
				}
			}
		);
  	}

  	// Create CSV Output
	if(document.getElementById('sql_output_format_csv_radio').checked)
	{
		file_format_selected = true;
		$.ajax(
			{
				url:"php/output_format_csv.php", //the page containing php script
				type: "POST", //request type
				data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
				success:function(result)
				{
					document.getElementById("download_file").href = "downloads/".concat(result); 
					document.getElementById("download_file").download = result;
					document.getElementById('download_file').click();
							
							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>CSV file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>CSV file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}$(output).appendTo("#query_result_downloads_ul");
				}
			}
		);
  	}

  	// Create HTML output
	if(document.getElementById('sql_output_format_html_radio').checked)
	{
		file_format_selected = true;
		$.ajax(
			{
				url:"php/output_format_html.php", //the page containing php script
				type: "POST", //request type
				data:{ query: query, hostip: hostip, r_type: r_type, r_smileys: r_smileys, lowercase:lowercase,findreplace:findreplace}, // Passing the query to a variable named 'query' in executeQuery	
				success:function(result)
				{
					document.getElementById("download_file").href = "downloads/".concat(result); 
					document.getElementById("download_file").download = result;
					document.getElementById('download_file').click();

							var output = "";
							if(result.indexOf(" ") > -1)
							{
								output = "<li>HTML file could not be created: <br><span style = 'font-size:0.5em;'>" + result + "</span>";
							}
							else
							{
								var output = "<li>HTML file created: <a href=\"downloads/".concat(result).concat('" download><b>Download File</b></a></li>');
		   			    	}
		   			    	$(output).appendTo("#query_result_downloads_ul");
				}
			}
		);
  	}
  	// If no File Format Is Selected, Then Alert The User*/
  	if(file_format_selected == false)
  	{
  		if(language == "EN")
	  		alert("Note: No Output Format Selected");
	  	else
	  		alert("Remarque: Non format de sortie sélectionné");
  	}
}


// The Main Function, It Starts When The Website Is Launched
function start(){
	// Add the Default Text For The Metadata
  	document.getElementById("form_metadata_input").placeholder = "\"lang-english\";\"Value1\";\"Value2\" ...\n\"lang-french\";\"Value1\";\"Value2\" ....\n\"primary_key_col\";\"new_col_1\";\"new_col_2\"; ...\n\"id_1\";\"new_col_1_val_1\";\"new_col_2_val_1\";....\n\"id_2\";\"new_col_1_val_2\";\"new_col_2_val_2\";....\n\"id_3\";\"new_col_1_val_3\";\"new_col_2_val_3\";....\n\"id_4\";\"new_col_1_val_4\";\"new_col_2_val_4\";....\n..\n..";
	
	// Zoom In The Website to 1.3 Times, It looks better!
	document.body.style.zoom = "100%";

	// Display of all the options set to be none.
	e[1].style.display = "none";
	e[2].style.display = "none";
	e[3].style.display = "none";
	e[4].style.display = "none";
	e[5].style.display = "none";
	f[0].style.display = "none";
	f[2].style.display = "none";
	q[1].style.display = "none";
	q[2].style.display = "none";
	about[1].style.display = "none";
	about[2].style.display = "none";
	about[3].style.display = "none";
	about[4].style.display = "none";
	about[5].style.display = "none";
	loadTextFields();
	loadMetadataFields();
	buildHistory();
	buildShared();
	loadPrimaryKeys();
}

// Signing out, call the logout.php script.
function sign_out()
{
	$.ajax(
		{
			url:"php/logout.php", //the page containing php script
			type: "POST", //request type
			data:{}, // Passing the query to a variable named 'query' in executeQuery	
			success:function(result)
			{
				if(result == "true")
					window.location.href = "index.php";
			}
		}
	);

}

// curr is a variable which tells the current 
// option(either of the 6, text fields, metadata, sorting, filters, pretreatments, file output)
// in the SubCorpora app. Initially set to be 0th, that is, the text fields.
var curr = 0;

// Used to go to any other option!
function goto(N)
{
	if(N == 2)
	{
		loadFilters();
	}	
	if(N == 3)
	{
		loadSorts();
	}

			e[curr].style.display = "none";
			e[N].style.display = "block";
			curr = N;
}


// Used to go to any other option!
// Used for metadata
curr_metadata = 1;
function metadata_goto(N)
{
			f[curr_metadata].style.display = "none";
			f[N].style.display = "block";
			curr_metadata = N;
}


// Used to go to any other option!
// Used for sql query
curr_sql = 0;
function gotoSQL(N)
{
			q[curr_sql].style.display = "none";
			q[N].style.display = "block";
			curr_sql = N;
}

// Process The Metadata, Needs Improvement!
function updateMetadata()
{
	//php/updateMetadata.php
	var val = document.getElementById("form_metadata_input").value;

	/*Process Metadata*/
	$.ajax(
		{
			url:"php/updateMetadata.php", //the page containing php script
			type: "POST", //request type
			data:{val: val}, // Passing the val to a variable named 'val' in updateMetadata	
			success:function(result)
			{
				if(result != "")
				{
					document.getElementsByClassName("form_metadata_output")[1].innerHTML = result;
				}
				else
				{
					document.getElementsByClassName("form_metadata_output")[1].innerHTML = "Updated Successfully!!";
				}
			}
		}
	);

	val = "METADATA:\n".concat(val);
	/*Log The User*/
	$.ajax(
		{
			url:"php/log.php", //the page containing php script
			type: "POST", //request type
			data:{ query: val, hostip: hostip, query_name: query_name}, // Passing the val to a variable named 'query' in log	
			success:function(result)
			{
			}
		}
	);
}

// Used to upload the CSV for adding the metadata, process the CSV, add the new columns and values.
function uploadMetadataCSV()
{
	var file_data = $('#metadata_box_file').prop('files')[0];   
	var form_data = new FormData();
	form_data.append('metadata_file', file_data);
	/*Process Metadata*/
	$.ajax(
		{
			url: 'php/uploadMetadataCSV.php', // point to server-side PHP script 
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data:form_data,
			type: 'POST',
			success:function(result)
			{
				if(result != "")
					document.getElementsByClassName("form_metadata_output")[0].innerHTML = result;
				else
					document.getElementsByClassName("form_metadata_output")[0].innerHTML = "Updated Successfully!!";
			}
		}
	);
}

// Loading the text fields in the Expora
function loadTextFields()
{
	var lang;
	if(language == "EN")
		lang = "english";
	else
		lang = "french";
	/*Load Text Field Data With loadTextFields.php script*/
	$.ajax(
		{
			url:"php/loadTextFields.php", //the page containing php script
			type: "POST", //request type
			data:{language: lang}, // Passing the val to a variable named 'query' in log	
			success:function(result)
			{
				if((result.toLowerCase()).includes("error"))
				{
					alert(result + "\nCheck the prefix for tables in connect.php file.");
				}
				var lines = result.split(";"); 
				var constant_table = "";
				for(var i = 1; i < lines.length; i++)
				{
					var infos = lines[i].split("|");
					var column_name = infos[0];
					var table_name = infos[1];
					var text = infos[2];
					if(constant_table == "")
					{
						constant_table = table_name;
						var hr = "<b>Table " + table_name + ":</b><br>";
						$(hr).appendTo("#text_fields");
					}
					if(table_name != constant_table)
					{
						var hr = "<hr><b>Table " + table_name + ":</b><br>";
						$(hr).appendTo("#text_fields");
						constant_table = table_name;
					}
					var output = "<div class=\"checkbox\"><label><input id = \"".concat(table_name).concat("__").concat(column_name).concat("\" name = \"textdata_checkbox\" type=\"checkbox\" name=\"").concat(table_name).concat("__").concat(column_name).concat("\"><div style = \"display: inline-block\">").concat(text).concat(" (").concat(table_name).concat(".").concat(column_name).concat(")").concat("</div></label></div>");
   			    	$(output).appendTo("#text_fields");
				}
			}
		}
	);
}

// Loading the metadata fields in the Expora
function loadMetadataFields()
{
	var lang;
	if(language == "EN")
		lang = "english";
	else
		lang = "french";
	/*Load Text Field Data With loadTextFields.php script*/
	$.ajax(
		{
			url:"php/loadMetadataFields.php", //the page containing php script
			type: "POST", //request type
			data:{language: lang}, // Passing the val to a variable named 'query' in log	
			success:function(result)
			{
				var lines = result.split(";"); 
				var constant_table = "";
				for(var i = 1; i < lines.length; i++)
				{
					var infos = lines[i].split("|");
					var column_name = infos[0];
					var table_name = infos[1];
					var text = infos[2];
					if(constant_table == "")
					{
						constant_table = table_name;
						var hr = "<b>Table " + table_name + ":</b><br>";
						$(hr).appendTo("#metadata_fields");
					}
					if(table_name != constant_table)
					{
						var hr = "<hr><b>Table " + table_name + ":</b><br>";
						$(hr).appendTo("#metadata_fields");
						constant_table = table_name;
					}
					var output = "<div class=\"checkbox\"><label><input id = \"".concat(table_name).concat("__").concat(column_name).concat("\" name = \"metadata_checkbox\" type=\"checkbox\" name=\"").concat(table_name).concat("__").concat(column_name).concat("\"><div style = \"display: inline-block\">").concat(text).concat(" (").concat(table_name).concat(".").concat(column_name).concat(")").concat("</div></label></div>");
   			    	$(output).appendTo("#metadata_fields");
				}
			}
		}
	);
}

// Loading the Dropdown list of Sorting whenever it is chosen
function loadSorts()
{


	var i = 0;
	tables_used = [];

	var textdata = document.getElementsByName("textdata_checkbox");
	for(i = 0; i < textdata.length; i++)
	{
		if(textdata[i].checked)
		{
			addTable(((textdata[i].id).replace("__",";")).substr(0, ((textdata[i].id).replace("__",";")).indexOf(';')));
		}
	}
	var metadata = document.getElementsByName("metadata_checkbox");
	for(i = 0; i < metadata.length; i++)
	{
		if(metadata[i].checked)
		{
			addTable(((metadata[i].id).replace("__",";")).substr(0, ((metadata[i].id).replace("__",";")).indexOf(';')));
		}
	}

	var select = document.getElementById("request_sort_field");

	// Before deleting the list, save the last selected option
	var old_selected = select.options[select.selectedIndex].value;
	
	// Delete the list 
	select.options.length = 1;
	select.innerHTML = "";

	var opt = "<option selected disabled style = 'display: none;' id = 'request_filter_field_title'>Field To Use</span></span></option>";
	$(opt).appendTo("#request_sort_field");


	// Update The List
	for(i = 0; i < tables_used.length; i++)
	{
		var table_name = tables_used[i];
		$.ajax(
			{
				url:"php/loadFilterFields.php", //the page containing php script
				type: "POST", //request type
				data:{ language: language, table_name: table_name}, // Passing the query to a variable named 'query' in executeQuery	
				success:function(result)
				{
					var column_name;
					var column_value;
					var flag = true;
					while(result != "")
					{
						column_name = result.substr(0, result.indexOf('|'));

						if(flag)
						{
							flag = false;
							table_name = column_name;
							var optgroup = "<optgroup label=' ---------- Table " + table_name + " ---------- '>";
							$(optgroup).appendTo("#request_sort_field");
						}
						else
						{
							column_name = result.substr(0, result.indexOf('|'));
							result = result.substr(result.indexOf('|') + 1);
							column_value = result.substr(0, result.indexOf('|'));
							select.options[select.options.length] = new Option(column_value.concat("(").concat(table_name).concat(".").concat(column_name).concat(")"), table_name.concat(".").concat(column_name));	
						}
						
						result = result.substr(result.indexOf('|') + 1);
					}

				},
				complete: function()
				{
					var optgroup = "</optgroup>";
					$(optgroup).appendTo("#request_sort_field");
				
					// Set default selected option to be 0, (Select Field For Sorting)
					select.selectedIndex = 0;

					// If the old selected option still exists in the list, choose that!
					len = select.options.length;
					for(i = 0; i < len; i++)
					{
						if(select.options[i].value == old_selected)
						{
							select.selectedIndex = i;
						}
					}
				}
			}
		);
	}
}

// Used for loading the filters whenever filter page has been called.
function loadFilters()
{



	var i = 0;
	tables_used = [];

	var textdata = document.getElementsByName("textdata_checkbox");
	for(i = 0; i < textdata.length; i++)
	{
		if(textdata[i].checked)
		{
			addTable(((textdata[i].id).replace("__",";")).substr(0, ((textdata[i].id).replace("__",";")).indexOf(';')));
		}
	}
	var metadata = document.getElementsByName("metadata_checkbox");
	for(i = 0; i < metadata.length; i++)
	{
		if(metadata[i].checked)
		{
			addTable(((metadata[i].id).replace("__",";")).substr(0, ((metadata[i].id).replace("__",";")).indexOf(';')));
		}
	}

	var select = document.getElementById("request_filter_field");

	// Before deleting the list, save the last selected option
	var old_selected = select.options[select.selectedIndex].value;
	
	// Delete the list 
	select.options.length = 1;
	select.innerHTML = "";

	var opt = "<option selected disabled style = 'display: none;' id = 'request_filter_field_title'>Field To Use</span></span></option>";
	$(opt).appendTo("#request_filter_field");

	// Update The List
	for(i = 0; i < tables_used.length; i++)
	{
		var table_name = tables_used[i];
		$.ajax(
			{
				url:"php/loadFilterFields.php", //the page containing php script
				type: "POST", //request type
				data:{ language: language, table_name: table_name}, // Passing the query to a variable named 'query' in executeQuery	
				success:function(result)
				{
					var column_name;
					var column_value;
					var flag = true;
					while(result != "")
					{
						column_name = result.substr(0, result.indexOf('|'));

						if(flag)
						{
							flag = false;
							table_name = column_name;
							var optgroup = "<optgroup label=' ---------- Table " + table_name + " ---------- '>";
							$(optgroup).appendTo("#request_filter_field");
						}
						else
						{
							column_name = result.substr(0, result.indexOf('|'));
							result = result.substr(result.indexOf('|') + 1);
							column_value = result.substr(0, result.indexOf('|'));
							select.options[select.options.length] = new Option("".concat(column_value).concat("(").concat(table_name).concat(".").concat(column_name).concat(")"), table_name.concat(".").concat(column_name));	
						}
						
						result = result.substr(result.indexOf('|') + 1);
					}

				},
				complete: function()
				{
					var optgroup = "</optgroup>";
					$(optgroup).appendTo("#request_filter_field");
					// Set default selected option to be 0, (Select Field For Filtering)
					select.selectedIndex = 0;

					// If the old selected option still exists in the list, choose that!
					len = select.options.length;
					for(i = 0; i < len; i++)
					{
						if(select.options[i].value == old_selected)
						{
							select.selectedIndex = i;
						}
					}
				}
			}
		);
	}

}

// Changing The Filter, Showing Corresponding Input Options
function changeFilter()
{
	if(document.getElementById("request_filter_type").selectedIndex == 1)
	{
		document.getElementById("request_filter_value").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "block";
	}
	if(document.getElementById("request_filter_type").selectedIndex == 2)
	{
		document.getElementById("request_filter_value").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
	}
	if(document.getElementById("request_filter_type").selectedIndex == 3)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}
	if(document.getElementById("request_filter_type").selectedIndex == 4)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}
	else if(document.getElementById("request_filter_type").selectedIndex == 5)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "none";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}
	if(document.getElementById("request_filter_type").selectedIndex == 6)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}
	if(document.getElementById("request_filter_type").selectedIndex == 7)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}
	if(document.getElementById("request_filter_type").selectedIndex == 8)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}
	if(document.getElementById("request_filter_type").selectedIndex == 9)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}
	if(document.getElementById("request_filter_type").selectedIndex == 10)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}
	
	if(document.getElementById("request_filter_type").selectedIndex == 11)
	{
		document.getElementById("request_filter_value").style.display = "block";
		document.getElementById("request_filter_field").style.display = "block";
		document.getElementById("request_filter_interval_inputs").style.display = "none";
		document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	}

}
// Is it the first filter? if Cflag == true, then yes.
var Cflag = true;
function addFilter(andor)
{
	filter = document.getElementById("request_filter_finalvalue").value;
	document.getElementById('request_filter_add_new').style.display = 'none';
	document.getElementById('request_filter_add').style.display = 'block';
	if(Cflag)
	{
		flag = false;
	}
	filter = (filter).concat(" ").concat(andor).concat(" ");
	document.getElementById("request_filter_finalvalue").value = filter;
	document.getElementById("request_filter_type").selectedIndex = 0;
	document.getElementById("request_filter_field").selectedIndex = 0;
	document.getElementById("request_filter_field").style.display = "block";
	document.getElementById("request_filter_value").value = "";
	document.getElementById("request_filter_interval_max").value = "";
	document.getElementById("request_filter_interval_min").value = "";
}

// To Load The Text Dynamically On Filter Field
function dynamicLoad()
{
	var filter_type = document.getElementById("request_filter_type");
	var output = document.getElementById("request_filter_finalvalue").value;
	document.getElementById('request_filter_add_new').style.display = 'none';
	document.getElementById('request_filter_add').style.display = 'block';
	var filter_field = document.getElementById("request_filter_field");
	var field = filter_field.options[filter_field.selectedIndex].value;
	filter_type = document.getElementById("request_filter_type");
	var type = filter_type.options[filter_type.selectedIndex].value;
	var field_value = document.getElementById("request_filter_value").value;
	var maxvalue = document.getElementById("request_filter_interval_max").value;
	var minvalue = document.getElementById("request_filter_interval_min").value;
	var greaterthan = document.getElementById("request_filter_interval_greaterthan").value;
	var lessthan = document.getElementById("request_filter_interval_lessthan").value;
	// Interval Equation
	if(filter_type.selectedIndex == 1)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		if(maxvalue != "" && minvalue != "")
		{
			output = ("(").concat(filter).concat("(").concat(field).concat(" >= ").concat(minvalue).concat(" AND ").concat(field).concat(" <= ").concat(maxvalue).concat(")").concat(")");
		}
		else if(maxvalue != "")
		{
			output = ("(").concat(filter).concat("(").concat(field).concat(" <= ").concat(maxvalue).concat(")").concat(")");
		}
		else if(minvalue != "")
		{
			output = ("(").concat(filter).concat("(").concat(field).concat(" >= ").concat(minvalue).concat(")").concat(")");
		}
		else if(maxvalue == "" && minvalue == "")
			output = ("(").concat(filter).concat(")");
	}

	// NOT Interval Equation
	if(filter_type.selectedIndex == 2)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		if(greaterthan != "" && lessthan != "")
		{
			output = ("(").concat(filter).concat("(").concat(field).concat(" > ").concat(greaterthan).concat(" OR ").concat(field).concat(" < ").concat(lessthan).concat(")").concat(")");
		}
		else if(greaterthan != "")
		{
			output = ("(").concat(filter).concat("(").concat(field).concat(" > ").concat(greaterthan).concat(")").concat(")");
		}
		else if(lessthan != "")
		{
			output = ("(").concat(filter).concat("(").concat(field).concat(" < ").concat(lessthan).concat(")").concat(")");
		}
		else if(greaterthan == "" && lessthan == "")
			output = ("(").concat(filter).concat(")");
	}

	// Regular Exp
	else if(filter_type.selectedIndex == 3)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat(" REGEXP '")).concat(field_value)).concat("')")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}


	// Unlike Regular Exp
	else if(filter_type.selectedIndex == 4)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat(" NOT REGEXP '")).concat(field_value)).concat("')")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}

	// Simple SQL
	else if(filter_type.selectedIndex == 5)
	{
		output = ("(").concat(filter).concat((("(").concat(field_value)).concat(")")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}

	// Equals
	else if(filter_type.selectedIndex == 6)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat("='")).concat(field_value)).concat("')")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}

	// NOT Equals
	else if(filter_type.selectedIndex == 7)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat("<>'")).concat(field_value)).concat("')")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}

	// Items from List
	else if(filter_type.selectedIndex == 8)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat(" IN (")).concat(field_value)).concat(")")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}

	// Items not in List
	else if(filter_type.selectedIndex == 9)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat(" NOT IN (")).concat(field_value)).concat(")")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}

	// Starts With
	else if(filter_type.selectedIndex == 10)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat(" LIKE '")).concat(field_value)).concat("%')")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}


	// Ends With
	else if(filter_type.selectedIndex == 11)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat(" LIKE '%")).concat(field_value)).concat("')")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}
	// Contains
	else if(filter_type.selectedIndex == 12)
	{
		if(filter_field.selectedIndex == 0)
		{
			alert("Please Select The Field for Filtering");
			return;
		}
		output = ("(").concat(filter).concat((((("(").concat(field)).concat(" LIKE '%")).concat(field_value)).concat("%')")).concat(")");
		if(field_value == "")
			output = ("(").concat(filter).concat(")");
	}
	if(Cflag)
	{
		output = output.substr(1, output.length - 2);
	}
	document.getElementById("request_filter_finalvalue").value = output;
}

// When we try to edit the filter, all current options go to default.
function editFilter()
{
	filter = document.getElementById("request_filter_finalvalue").value;
	document.getElementById("request_filter_type").selectedIndex = 7;
	document.getElementById("request_filter_field").selectedIndex = 0;
	document.getElementById("request_filter_field").style.display = "block";
	document.getElementById("request_filter_interval_inputs").style.display = "none";
	document.getElementById("request_filter_not_interval_inputs").style.display = "none";
	document.getElementById("request_filter_value").style.display ="block"
	document.getElementById("request_filter_value").value = "";
	document.getElementById("request_filter_interval_max").value = "";
	document.getElementById("request_filter_interval_min").value = "";
}

// Building the history pane whenever the website is loaded.
function buildHistory()
{
	var lang;
	document.getElementById("form_history_table").innerHTML = "";
	var table = document.getElementById("form_history_table");
	var output = "<thead><tr><th><span class = 'log_queryname_title'>Name</span></th><th><span class = 'log_time_title'>Time</span></th><th><span class = 'log_query_title'>Query</span></th><th><span class = 'log_shared_title'>Shared</span></th><th><span class = 'log_favourites_title'>Favourites</span></th></tr></thead>";
	$(output).appendTo("#form_history_table");
	if(language == "EN")
		lang = "english";
	else
		lang = "french";
	/*Load Text Field Data With loadTextFields.php script*/
	$.ajax(
		{
			url:"php/buildHistory.php", //the page containing php script
			type: "POST", //request type
			data:{language: lang}, // Passing the val to a variable named 'query' in log	
			success:function(result)
			{
				var lines = result.split("#");
				for(var i = 1; i < lines.length; i++)
				{
					var infos = lines[i].split("|");
					var query = infos[0];
					var shared = infos[1];
					var fav = infos[2];
					var time = infos[3];
					var query_name = infos[4];
					
					var output = "<tr><td>".concat(query_name).concat("</td><td>").concat(time).concat("</td><td id = 'history_query_").concat(i.toString()).concat("'>").concat("</td><td id = 'shared_").concat(i.toString()).concat("'><span style = 'display:none'>").concat(shared).concat("</span></td><td id = 'fav_").concat(i.toString()).concat("'><span style = 'display:none'>").concat(fav).concat("</span></td></tr>");
   			    	$(output).appendTo("#form_history_table");

   			    	var queryId = document.getElementById(("history_query_").concat(i.toString()));

   			    	var querydiv = document.createElement("div");

   			    	querydiv.innerHTML = query;
   			    	querydiv.onclick = function(){
   			    		loadQuery(this.innerHTML);
   			    	};
   			    	querydiv.className = "queryClass";
   			    	queryId.appendChild(querydiv);

   			    	var sharedId = document.getElementById(("shared_").concat(i.toString()));
					var inputShared = document.createElement("input");
					inputShared.type = "button";
				    inputShared.setAttribute("id", "s__".concat(time));
					if(shared == 1)
					{
						inputShared.value = "Yes";
						inputShared.className = "btn btn-success"; // set the CSS class
					}
					else
					{
						inputShared.value = "No";
						inputShared.className = "btn btn-danger"; // set the CSS class
					}
					inputShared.onclick = function(){
					    addRemoveSharedFav("s", this.id);
					};
					sharedId.appendChild(inputShared);


   			    	var favId = document.getElementById(("fav_").concat(i.toString()));
					var inputFav = document.createElement("input");
					inputFav.type = "button";
				    inputFav.setAttribute("id", "f__".concat(time));
					if(fav == 1)
					{
						inputFav.value = "Yes";
						inputFav.className = "btn btn-success"; // set the CSS class
					}
					else
					{
						inputFav.value = "No";
						inputFav.className = "btn btn-danger"; // set the CSS class
					}
					inputFav.onclick = function(){
					    addRemoveSharedFav("f", this.id);
					};
					favId.appendChild(inputFav);
				}

				$('#form_history_table').DataTable();
			}
		}
	);
}

// Building the shared pane whenever the website is loaded.
function buildShared()
{
	var output = "<thead><tr><th><span class ='log_queryname_title'>Name</span></th><th><span class ='log_time_title'>Time</span></th><th><span class ='log_query_title'>Query</span></th><th><span class ='log_sharedby_title'>Shared By</span></th></tr></thead>";
	document.getElementById("form_shared_table").innerHTML = "";
	$(output).appendTo("#form_shared_table");

	var lang;
	if(language == "EN")
		lang = "english";
	else
		lang = "french";
	/*Load Text Field Data With loadTextFields.php script*/
	$.ajax(
		{
			url:"php/buildShared.php", //the page containing php script
			type: "POST", //request type
			data:{language: lang}, // Passing the val to a variable named 'query' in log	
			success:function(result)
			{
				var lines = result.split("#"); 
				for(var i = 1; i < lines.length; i++)
				{
					var infos = lines[i].split("|");
					var query = infos[0];
					var user = infos[1];
					var time = infos[2];
					var query_name = infos[3];
					var output = "<tr><td>".concat(query_name).concat("</td><td>").concat(time).concat("</td><td id = 'shared_query_").concat(i.toString()).concat("'>").concat("</td><td>").concat(user).concat("</td></tr>");
   			    	$(output).appendTo("#form_shared_table");

   			    	var queryId = document.getElementById(("shared_query_").concat(i.toString()));

   			    	var querydiv = document.createElement("div");

   			    	querydiv.innerHTML = query;
   			    	querydiv.onclick = function(){
   			    		loadQuery(this.innerHTML);
   			    	};
   			    	querydiv.className = "queryClass";
   			    	queryId.appendChild(querydiv);

				}
				$('#form_shared_table').DataTable();
			}
		}
	);
}

// Is query shared?
function addShared()
{
	shared = 1;
}

// Is query added in Favourites?
function addFavourite()
{
	favourite = 1;
}

// Load the primary keys of the main tables, to use in future.
function loadPrimaryKeys()
{
	var list = document.getElementById("form_metadata_primary_keys_value");
	$.ajax(
	{
		url:"php/loadPrimaryKeys.php",	
		success:function(result)
		{
			var lines = result.split("#"); 
			for(var i = 1; i < lines.length; i++)
			{
				var li = document.createElement("li");
				var infos = lines[i].split("|");
				var table_name = infos[0];
				var primary_key = infos[1];
				li.appendChild(document.createTextNode(("Table '").concat(table_name).concat("': ").concat(primary_key)));
				list.appendChild(li);
			}
		}
	}
	);
}
// What to change? Shared or Favourite? By SF
function addRemoveSharedFav(SF, changeid)
{
	var time = changeid.substr(3);
	var input = document.getElementById(changeid);
	$.ajax(
	{
		url:"php/addRemoveSharedFav.php",	
		type: "POST",
		data:{time: time, SF: SF},
		success:function(result)
		{
			if(result[0] == 1)
			{
				input.setAttribute("value", "Yes");
				input.setAttribute("class", "btn btn-success");
			}
			else
			{
				input.setAttribute("value", "No");
				input.setAttribute("class", "btn btn-danger");
			}
		}
	}
	);
}


// Loading the query when we click on any query in HISTORY or SHARED pane.
function loadQuery(query)
{
	query = query.replace("&gt;", ">");
	query = query.replace("&lt;", "<");
	var select = "select ";
	var from = "from ";
	var where = "where ";
	var orderby = "order by ";

	document.getElementById("sql_query_form_input_select").value = "";
	
	document.getElementById("sql_query_form_input_from").value = "";
	
	document.getElementById("sql_query_form_input_where").value = "";
	
	document.getElementById("sql_query_form_input_order").value = "";
	
	if(query.toLowerCase().indexOf(orderby.toLowerCase()) > -1)
	{
		orderby = query.substring(query.toLowerCase().indexOf(orderby.toLowerCase()) + orderby.length);
		query = query.substring(0, query.toLowerCase().indexOf("order by "));
		document.getElementById("sql_query_form_input_order").value = orderby;
	}
	if(query.toLowerCase().indexOf(where.toLowerCase()) > -1)
	{
		where = query.substring(query.toLowerCase().indexOf(where.toLowerCase()) + where.length);
		query = query.substring(0, query.toLowerCase().indexOf("where "));
		document.getElementById("sql_query_form_input_where").value = where;
	}
	if(query.toLowerCase().indexOf(from.toLowerCase()) > -1)
	{
		from = query.substring(query.toLowerCase().indexOf(from.toLowerCase()) + from.length);
		query = query.substring(0, query.toLowerCase().indexOf("from "));
		document.getElementById("sql_query_form_input_from").value = from;
	}
	if(query.toLowerCase().indexOf(select.toLowerCase()) > -1)
	{
		select = query.substring(query.toLowerCase().indexOf(select.toLowerCase()) + select.length);
		query = query.substring(0, query.toLowerCase().indexOf("select "));
		document.getElementById("sql_query_form_input_select").value = select;
	}

	switch_sqlquery();
}

// Showing and and or when we try to add a new filter.
function showANDOR()
{
	document.getElementById('request_filter_add_new').style.display = 'block';
	document.getElementById('request_filter_add').style.display = 'none';

}

$('#request_filter_field').on('change', function (e) {
	dynamicLoad();
});



// This function is used to switch panes in 'About Expora'
var curr_ABOUT = 0;
function gotoABOUT(N)
{
			about[curr_ABOUT].style.display = "none";
			about[N].style.display = "block";
			curr_ABOUT = N;
}
