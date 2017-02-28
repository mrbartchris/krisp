<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Krisp Games Login Page">
	<meta name="author" content="Krisp">
	<link rel="icon" href="icon.png">
	<title>Landing Page</title>
	
	<link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href = "./signin.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-default navbar-fixed-top navPadTop">
	<div class="container">
		<div class="collapse navbar-collapse">
			<a href ="landing.html.php"> <img src="icon.png" width="40px"></a>
			<a href="signOutRedirect.html.php" class="btn btn-primary navbar-right" name="log"
			>Sign out</a>
		</div>
	</div>
</nav>


<div class="container-fluid headPadTop">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h1 class="largeTextC">
				Welcome <?php session_start();
				echo "".$_SESSION['uname']."!"; ?>
			</h1>
			<BR>
		</div>
	</div>
	<div id="jscb">
			<script src="./Testing/circles.js"></script>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>