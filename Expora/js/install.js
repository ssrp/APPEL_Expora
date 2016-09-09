// THIS VARIABLE IS USED TO SET THE PANE TO BE USED IN THE INSTALLATION PAGE.
var currSetup = 0;
var e = document.getElementsByClassName("setup_options");

// ATTRIBUTES FOR THE CONNECT.PHP FILE
var servername = "";
var username = "";
var password = "";
var dbname = "";
var auth = "";
var system = "";
var tableOne = "";
var tableTwo = "";
var tableOne_PK = "";
var tableTwo_PK = "";
var foreignK = "";
var prefix = "";
var connectCreated = false;

// Number of fields to be loaded in the third pane, to add the description.
var data = 0;


// Start function
function start()
{
	e[1].style.display = "none";
	e[2].style.display = "none";
	loadIfPresent();
}

// Changing the panes.
function gotoSetup(N)
{
	if(N == 1 && connectCreated == false)
	{
		alert("Please create a connect file first.");
		return;
	}
	e[currSetup].style.display = "none";
	e[N].style.display = "block";
	currSetup = N;
}

function loadIfPresent()
{

}

// this function is used to create the connect.php file if everything is right.
function setupConnect()
{
	servername = document.getElementById("servername").value;
	username = document.getElementById("username").value;
	password = document.getElementById("password").value;
	dbname = document.getElementById("dbname").value;
	auth = document.getElementById("auth").value;
	system = document.getElementById("system").value;
	tableOne = document.getElementById("tableOne").value;
	tableTwo = document.getElementById("tableTwo").value;
	tableOne_PK = document.getElementById("tableOne_PK").value;
	tableTwo_PK = document.getElementById("tableTwo_PK").value;
	foreignK = document.getElementById("foreignK").value;
	prefix = document.getElementById("prefix").value;
	if(servername == "" || username == "" || dbname == "" || auth == "" || system == "" || tableOne == "" || tableOne_PK == "")
	{
		alert("The fields with * cannot be null.");
		return;
	}
	if(system.toUpperCase() == "MYSQL")
	{
		system = "MySQL";
	}
	else if(system.toUpperCase() == "POSTGRESQL")
	{
		system = "PostgreSQL";
	}
	else{
		alert("System can only be 'MySQL' or 'PostgreSQL'");
		return;
	}
	/*Executing the Query*/
	$.ajax(
		{
			url:"php/createConnect.php", //the page containing php script
			type: "POST", //request type
			data:{servername:servername, username:username, foreignK: foreignK, password:password, dbname:dbname, auth:auth, system:system, tableOne:tableOne, tableTwo:tableTwo, tableOne_PK:tableOne_PK, tableTwo_PK:tableTwo_PK, prefix:prefix}, 
			success:function(result)
			{
			},
	  	complete: function(){
			}
		}
	);
	/*Executing the Query*/
	$.ajax(
		{
			url:"php/createDatabase.php", //the page containing php script
			type: "POST", //request type
			data:{servername:servername, username:username, foreignK: foreignK, password:password, dbname:dbname, auth:auth, system:system, tableOne:tableOne, tableTwo:tableTwo, tableOne_PK:tableOne_PK, tableTwo_PK:tableTwo_PK, prefix:prefix}, 
			success:function(result)
			{
				if(result == "")
				{
					alert("SUCCESSFUL. Please Check Your File In 'Installation' Folder.");
					connectCreated = true;
					document.getElementById("database_name").innerHTML = dbname;
					document.getElementById("system_type").innerHTML = system;
					if(system == "MySQL")
					{
						document.getElementById("system_panel").innerHTML = "phpMyAdmin";
					}
					if(system == "PostgreSQL")
					{
						document.getElementById("system_panel").innerHTML = "phpPgAdmin";
					}
					gotoSetup(1);
				}
				else
					document.getElementById("connect_output").innerHTML = result;
			},
	  	complete: function(){

			}
		}
	);
}

// This function is used to setup(load) the fields description in the third pane.
function setupFields()
{
	document.getElementById("table_details").innerHTML = "";
	var res;
	// PUT DATA IN THE FIELDS TABLE
	$.ajax(
		{
			url:"php/insertFields.php", //the page containing php script
			type: "POST", //request type
			data:{servername:servername, username:username, foreignK: foreignK, password:password, dbname:dbname, auth:auth, system:system, tableOne:tableOne, tableTwo:tableTwo, tableOne_PK:tableOne_PK, tableTwo_PK:tableTwo_PK, prefix:prefix}, 
			success:function(result)
			{
				res = result;
				if(result == "")
				{

				}
				else
				{
					// alert(result);
				}
			},
			complete:function()
			{
				var table = document.getElementById("table_details");
				var output = "<thead><tr><th>Column Name</th><th>Table</th><th>Type of Data</th><th>Description in English</th><th>Description in French</th></tr></thead>";
				$(output).appendTo("#table_details");
				var lines = res.split("#");
				data = lines.length;

				for(var i = 1; i < data; i++)
				{
					var infos = lines[i].split("|");
					var column_name = infos[0];
					var table_name = infos[1];
					
					var output = "<tr><td id = 'field__".concat(i).concat("'>").concat(column_name).concat("</td><td id = 'table__").concat(i).concat("'>").concat(table_name).concat("</td><td id = 'type_").concat(i.toString()).concat("'>").concat("</td><td id = 'english_").concat(i.toString()).concat("'>").concat("</td><td id = 'french_").concat(i.toString()).concat("'>").concat("</td></tr>");
   			    	$(output).appendTo("#table_details");

   			    	var type = document.getElementById(("type_").concat(i.toString()));

					$("<div class='checkbox' style = 'margin:0em; padding:0.1em'><label><input type = 'radio' name = 'type__" + i.toString() + "'> Text Data <br></label></div><div class='checkbox' style = 'margin:0em; padding:0.1em'><label><input type = 'radio' name = 'type__"+ i.toString() + "'> Metadata</label></div>" ).appendTo("#type_" + i.toString());


   			    	var english = document.getElementById(("english_").concat(i.toString()));

   			    	var english_input = document.createElement("input");
				    english_input.setAttribute("id", "english__".concat(i.toString()));
				    english_input.setAttribute("class", "form-control");
   			    	english_input.type = "text";
   			    	
   			    	english.appendChild(english_input);

   			    	var french = document.getElementById(("french_").concat(i.toString()));

   			    	var french_input = document.createElement("input");
				    french_input.setAttribute("id", "french__".concat(i.toString()));
				    french_input.setAttribute("class", "form-control");
   			    	french_input.type = "text";
   			    	
   			    	french.appendChild(french_input);

				}
				$('#table_details').DataTable();
			}
		}
	);
}

// This function is used after the description is put by the user in the fields, then the values are added using this script.
function updateFields()
{
	for(var i = 1; i < data; i++)
	{
		var column_name = document.getElementById("field__" + i.toString()).innerHTML;
		var type = "";
		if(document.getElementsByName("type__" + i.toString())[0].checked == true)
		{
			type = "text";
		}
		else
		{
			type = "metadata";
		}
		var table_name = document.getElementById("table__" + i.toString()).innerHTML;
		var english = document.getElementById("english__" + i.toString()).value;
		var french = document.getElementById("french__" + i.toString()).value;
		var query = "UPDATE " + prefix + "fields SET field_type = '" + type + "', english = '" + english + "', french = '" + french + "' WHERE (field_name = '"+ column_name + "' AND field_table = '" + table_name + "')";
		//alert(query);
		$.ajax(
			{
				url:"php/alterFields.php", //the page containing php script
				type: "POST", //request type
				data:{query:query,servername:servername, username:username, foreignK: foreignK, password:password, dbname:dbname, auth:auth, system:system, tableOne:tableOne, tableTwo:tableTwo, tableOne_PK:tableOne_PK, tableTwo_PK:tableTwo_PK, prefix:prefix},
				success:function(result)
				{
					if(result == "")
					{
					}
					else
						alert(result);
				},
		  	complete: function(){

				}
			}
		);
	}

}