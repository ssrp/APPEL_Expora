<!DOCTYPE html>
<html>
<head>
	<title>
		Install Expora
	</title>
	<link href = "css/fonts.css" rel = "stylesheet" type = "text/css" />
	<link href = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css" />
	<link href = "css/dataTables.bootstrap.min.css" rel = "stylesheet" type = "text/css" />
	<link href = "css/index.css" rel = "stylesheet" type = "text/css" />
 	<link rel="stylesheet" href="css/bootstrap-select.min.css">

	<!--
		Setting The Logo!
		-->
	<link rel="shortcut icon" href="images/logo-small.png">
</head>
<body onload = "start()">
	<h1 class = "text-center"><u>Expora</u> - <u>Ex</u>tract Cor<u>pora</u></h1>
	<h3 class = "text-center">INSTALLATION</h3>


	<hr>
	<nav class = "text-center" style = "margin-bottom: 0em">
		<ul class="pagination">
			<li><a href="#" onclick = "gotoSetup(0)"><spna class = "">Setup connect.php File</span></a></li>
			<li><a href="#" onclick = "gotoSetup(1)"><spna class = "">Insert The Tables</span></a></li>
			<li><a href="#" onclick = "gotoSetup(2);setupFields()"><spna class = "">Setup Fields</span></a></li>
		</ul>
	</nav>
	<div class = "setup_options">
		<h2 class = "text-center"> -- Setup connect.php File --</h2>
		<br>
		<form class = "form-horizontal">
			<div class="form-group">
				<label for = "system" class="col-sm-4 control-label">Database Management System *</label>
				<div class="col-sm-6">
					<input type="text" id = "system" class="form-control" name = "connectphp" placeholder="'MySQL' or 'PostgreSQL'" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "servername" class="col-sm-4 control-label">Server Name *</label>
				<div class="col-sm-6">
					<input type="text" id = "servername" class="form-control" name = "connectphp" placeholder="localhost" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "username" class="col-sm-4 control-label">Username *</label>
				<div class="col-sm-6">
					<input type="text" id = "username" class="form-control" name = "connectphp" placeholder="root" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "password" class="col-sm-4 control-label">Password</label>
				<div class="col-sm-6">
					<input type="text" id = "password" class="form-control" name = "connectphp" placeholder="password" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "dbname" class="col-sm-4 control-label">Database Name(It Should Be A New Database Name) *</label>
				<div class="col-sm-6">
					<input type="text" id = "dbname" class="form-control" name = "connectphp" placeholder="myDatabase" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "auth" class="col-sm-4 control-label">Authorization Key *</label>
				<div class="col-sm-6">
					<input type="text" id = "auth" class="form-control" name = "connectphp" placeholder="Key For Signup" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "tableOne" class="col-sm-4 control-label">Table One Name *</label>
				<div class="col-sm-6">
					<input type="text" id = "tableOne" class="form-control" name = "connectphp" placeholder="tableName" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "tableTwo" class="col-sm-4 control-label">Table Two Name</label>
				<div class="col-sm-6">
					<input type="text" id = "tableTwo" class="form-control" name = "connectphp" placeholder="tableName (Optional)" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "tableOne_PK" class="col-sm-4 control-label">Primary Key for Table One *</label>
				<div class="col-sm-6">
					<input type="text" id = "tableOne_PK" class="form-control" name = "connectphp" placeholder="primaryKey" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "tableTwo_PK" class="col-sm-4 control-label">Primary Key for Table Two</label>
				<div class="col-sm-6">
					<input type="text" id = "tableTwo_PK" class="form-control" name = "connectphp" placeholder="primaryKey (Optional)" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "foreignK" class="col-sm-4 control-label">Foreign Key, To Connect The First Table With The Second</label>
				<div class="col-sm-6">
					<input type="text" id = "foreignK" class="form-control" name = "connectphp" placeholder="foreignKey" required>
				</div>
			</div>
			<div class="form-group">
				<label for = "prefix" class="col-sm-4 control-label">Prefix To Be Used</label>
				<div class="col-sm-6">
					<input type="text" id = "prefix" class="form-control" name = "connectphp" placeholder="prefix_ (Optional)" required>
				</div>
			</div>
		</form>
		
		<center>
		<div class="form-group">
			<div>
				<button type="submit" class="btn btn-default" onclick = "setupConnect()">Create connect.php File</button>
			</div>
		</div><br><br>
		<div id = "connect_output">
		</div>
		<br><br><br>
		</center>

	</div>
	<div class = "setup_options col-md-10 col-md-offset-1">
		<center>
			<h2 class = "text-center">-- Inserting The Main Tables --</h2>
			<h4>Your connect file is created in the <b>installation</b> folder in Expora. Please put this file in the <b>php</b> folder(replace old one if it exists). <br><br>The database <b><span id = "database_name"></span></b> is created in <b><span id = "system_type"></span></b> database management system. Please go to your admin panel(<b><span id = "system_panel"></span></b>) and import the two tables in the database. After uploading the tables, please click -</h4>
			<br>
			<button class="btn btn-default" onclick = "gotoSetup(2);setupFields()">Tables Uploaded Successfully</button>
		</center>
	</div>
	<div class = "setup_options">
		<h2 class = "text-center">-- Setup Fields --</h2>
		<center>
			<h4>Please describe the columns of the respective tables in both - English and French Language.</h4>
			<div style = "width:100%; padding-top:1%; padding-left:5%; padding-right:5%;">	
				<table id = "table_details" class="table table-striped table-bordered" cellspacing="0">
				</table>
			</div>
			<br>
			<button class="btn btn-default" onclick = "updateFields()">Update The Fields</button>
			<br><br>
		</center>

	</div>
	<script src="js/jquery.min.js"></script>
	<script type = "text/javascript" src = "js/install.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
<!--	<script type="text/javascript" src="http://l2.io/ip.js?var=hostip"></script>-->
	<script src="js/bootstrap-select.min.js"></script>
</body>
</html>