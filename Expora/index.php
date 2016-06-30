<?php
	// Resume a session.
  	session_start();
  	// If already started, then redirect to Expora.
  	if(isset($_SESSION['name']))
  	{
  		header( "refresh:0; url=expora.php");
	}
  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Expora - Login / Signup</title>
	
	<!--
		Using UTF-8
		-->
	<meta charset="utf-8">

	<!--
		Setting the viewports, as given in Bootstrap Docs.
		-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<!--
		Importing the css files.
		-->
	<link href = "css/fonts.css" rel = "stylesheet" type = "text/css" />
	<link href = "css/index.css" rel = "stylesheet" type = "text/css" />
	<link href = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css" />

	<!--
		Setting The Logo!
		-->
	<link rel="shortcut icon" href="images/logo-small.png">
</head>
<body>

		<!--
			Title
			-->
		<h1 class="text-center">
			- Expora -
		</h1>
		<br><br>

		<!--
			Using Bootstrap Classes
			-->
	<div class = "col-md-10 col-md-offset-1">


		<table class="table table-bordered">


			<tr>


				<td>
					<!--
						Log in Form
						-->
					<h2 class="text-center">Log In</h2>
					<hr>
					<br>
					<br>
					<form method = "post" action = "php/login.php" class = "form-horizontal">
						<div class="form-group">
							<label for = "login_username" class="col-sm-4 control-label">Username</label>
							<div class="col-sm-6">
								<input type="username" id = "login_username" class="form-control" name = "username" placeholder="Username" required>
							</div>
						</div>
						
						<div class="form-group">
							<label for = "login_password" class="col-sm-4 control-label">Password</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" id = "login_password" name = "password" placeholder="Password" required>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Sign in</button>
							</div>
						</div>
					</form>


				</td>


				<td>

					<!--
						Sign Up Form
						-->
					<h2 class="text-center">Sign Up</h2>
					<hr>
					<form method = "post" action = "php/signup.php" class = "form-horizontal">
						<div class="form-group">
							<label class="col-sm-4 control-label">Username</label>
							<div class="col-sm-6">
								<input type="username" class="form-control" name = "username" placeholder="Username" required>
							</div>
						</div>
							
						<div class="form-group">
							<label class="col-sm-4 control-label">Password</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" name = "password" placeholder="Password" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label">Re-Password</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" name = "repassword" placeholder="Re-Enter Your Password" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label">Authentication Key</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" name = "authentication_key" placeholder="Authentication Key" required>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Sign up</button>
							</div>
						</div>
					</form>


				</td>


			</tr>


		</table>


	</div>


	<!--
		jQuery, Bootstrap and index.js Scripts included at the last(adding the scripts at the last makes the website faster).
		-->
	<script type = "text/javascript" src = "js/index.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>