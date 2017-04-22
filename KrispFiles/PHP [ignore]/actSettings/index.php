<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Krisp Games - Account Settings">
	<meta name="author" content="Krisp">
	<link rel="icon" href="../icon.png">
	<title>Account Settings | Krisp</title>
	
	<link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../signin.css" rel="stylesheet">
</head>

<body>
	<?php 
		session_start();
		try { //establishing connection with db
			$pdo = new PDO('mysql:host=localhost;dbname=userdb', 'justme', 'eyesonly');
			$pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$pdo -> exec('SET NAMES "utf8"');
		}
		catch (PDOException $e){
			$error = 'Unable to connect to the database server.'."<BR>".$e->getMessage();
			include 'error.html.php';
			exit();
		}
	?>
	<nav class="navbar navbar-default navbar-fixed-top navPadTop">
		<div class="container">
			<div class="collapse navbar-collapse">
				<a href ="../landing.html.php"> <img title="Home" src="../icon.png" width="40px"></a>
				<ul class="nav navbar navbar-right nbRight">
					<a href="#" class="dropdown-toggle noULOH avPic" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" width="40px">
						<label id="usernameLabel"><?php echo $_SESSION['uname']; ?></label>
						<img id="avLabel" title="Account" src="../imgs/<?php echo "".$_SESSION['icon'];?>.png" width="40px" class= "img-circle"></a>
							<ul class="dropdown-menu">
								<li class="dropdown-header">Account Settings</li>
								<li><a href="?avat">Change Avatar</a></li>
								<li><a href="?user">Change Username</a></li>
								<li><a href="?pass">Change Password</a></li>
							</ul>
					<a href="../signOutRedirect.html.php" class="btn btn-primary" name="log">Sign out</a>
				</ul>
			</div>
		</div>
	</nav>
	
	<div class="container-fluid">
		<div class="row  headPadTop">
			<div class = "col-xs-2 col-sm-2 col-md-2 col-lg-2 sidebar" >
				<ul class="nav nav-sidebar">
					<li class="dropdown-header"><h4>Account Settings</h4></li>
					<li id="cavatar"><a href="?avat">Change Avatar</a></li>
					<li id="cusern"><a href="?user">Change Username</a></li>
					<li id="cpassw"><a href="?pass" >Change Password</a></li>
				</ul>
			</div>
			<div id="cDiv" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="container-fluid">
				<?php 
					if (isset($_GET['avat'])){
						include 'chavat.php';
						echo '<script>document.getElementById("cDiv").className = "col-xs-9 col-sm-9 col-md-9 col-lg-9";</script>';
						echo '<script>document.getElementById("cavatar").className = "active";</script>';
					} 
					if (isset($_GET['user'])){
						include 'chuser.php';
						echo '<script>document.getElementById("cusern").className = "active";</script>';
					} 
					if (isset($_GET['pass'])){
						include 'chpass.php';
						echo '<script>document.getElementById("cpassw").className = "active";</script>';
					} 
				?>
			</div>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
	<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
	<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>