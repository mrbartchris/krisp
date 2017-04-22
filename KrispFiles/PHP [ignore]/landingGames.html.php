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
	<?php 
		session_start();
		//$str = "\"C:/Program Files (x86)/nodejs/node.exe\" \"C:/xampp/htdocs/KrispFiles/iochat/server.js\"";
		//exec($str);
		$str = "node C:/xampp/htdocs/KrispFiles/iochat/server.js";
		pclose(popen('start /B cmd /C "'.$str.' >NUL 2>NUL"', 'r'));
	?>
	<nav class="navbar navbar-default navbar-fixed-top navPadTop">
		<div class="container">
			<div class="collapse navbar-collapse">
				<a href ="landing.html.php"> <img title="Home" src="icon.png" width="40px"></a>
				<ul class="nav navbar navbar-right nbRight">
					<a href="#" class="dropdown-toggle noULOH avPic" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" width="40px">
						<label><?php echo $_SESSION['uname']; ?></label>
						<img title="Account" src="imgs/<?php echo "".$_SESSION['icon'];?>.png" width="40px" class= "img-circle"></a>
							<ul class="dropdown-menu">
								<li class="dropdown-header">Account Settings</li>
								<li><a href="actSettings?avat">Change Avatar</a></li>
								<li><a href="actSettings?user">Change Username</a></li>
								<li><a href="actSettings?pass">Change Password</a></li>
							</ul>
					<a href="signoutRedirect.html.php" class="btn btn-primary" name="log">Sign out</a>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-fluid headPadTop">
	
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h1 class="largeTextC">
				Welcome <?php echo "".$_SESSION['uname']."!"; ?>
			</h1>
			<BR>
		</div>
		
		<div class="container-fluid">
			<div class="row">
			
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 sidebar" >
					<ul class="nav nav-sidebar">
						<li class="dropdown-header"><h4>Friends</h4></li>
						<li><div class="row">
							<div class="btn-group btn-group-justified">
							<a href="#" type="button" class="btn btn-info" data-toggle="modal" data-target="#addFriendModal">Add Friend</a>
							<a href="#" type="button" class="btn btn-success" data-toggle="modal" data-target="#invFriendModal">Invite Friend</a>
							</div>
						</div></li>
						<li class="frounded">
							<a class="friendstc" href="#">Friend 1</a>
							<a class="friendstc" href="#">Friend 2</a>
							<a class="friendstc" href="#">Friend 3</a>
							
							<?php
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
								
								
								try{ //selecting the current user
									$sql = "SELECT * FROM users WHERE username='".$_SESSION['uname']."'";
									$result = $pdo->query($sql);
									$row = $result -> fetch(); //where $row['username', 'password', 'email', verified']
									$sql2 = "SELECT * FROM friends WHERE email='".$row['email']."'";
									$result2 = $pdo->query($sql2);
								}
								catch(PDOException $e){
									$error = "".$e->getMessage();
									include "error.html.php";
									exit();
								}
								
							
								foreach($result2 as $row){
									try{ //selecting the current user
										$sql3 = "SELECT * FROM userProfile WHERE email='".$row['emailF']."'";
										$result3 = $pdo->query($sql3);
										$row3 = $result3 -> fetch(); //now contains all userprofile info for friend
										$sql4 = "SELECT * FROM users WHERE email='".$row['emailF']."'";
										$result4 = $pdo->query($sql4);
										$row4 = $result4 -> fetch(); //now contains all users info for friend
									}
									catch(PDOException $e){
										$error = "".$e->getMessage();
										include "error.html.php";
										exit();
									}
									
									echo '<a class="friendstc" href="#">
									<img class="frimage" src="imgs/'.$row3['iconNum'].'.png">'.htmlspecialchars($row4['username'],ENT_QUOTES,'UTF-8');
									if($row3['status'] == 0){
										echo '<img class="frstatus" src="imgs/offline.png"></a>';
									}
									else if($row3['status'] == 1){
										echo '<img class="frstatus" src="imgs/online.png"></a>';
									}
									
								}
								/*$arr = array("x","y","z","a","b","c");
								$i;
								for($i=0;$i<count($arr)-1;$i++){
									echo '<a class="friendstc" href="#">
									<img class="frimage" src="icon.png">'.$arr[$i].'
									<img class="frstatus" src="imgs/online.png"></a>';
								}
								echo '<a class="friendstc unBord" href="#">
								<img class="frimage" src="icon.png">'.$arr[$i].'
								<img class="frstatus" src="imgs/offline.png"></a>';*/
								
							?>
							<a class="friendstc unBord" href="#">Friend n</a>
						</li>
					</ul>
				</div>
				
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<div id="jscb">
					<script src="Testing/circles.js">
					</script>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
					<!-- To contain chat -->
				</div>
				
			</div>
		</div>
	</div>
	
	
	<div id="addFriendModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add Friend</h4>
		  </div>
		  <div class="modal-body">
				<form id = "addFriendForm" method="post">
					<div class = "input-group input-group-md"> 
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" class="form-control" id="usern" name="usern" placeholder="Username" required="">
					</div>
					<button type="submit" class="btn btn-primary btn-block margTop" name="addF">Add to Friends List!</button>
				</form>
		  </div>
		</div>
	  </div>
	</div>
	<?php
	if (isset($_POST['usern'])) {
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
		
		try{ //selecting the users
		$sql = "SELECT * FROM users WHERE username='".$_POST['usern']."'";
		$result = $pdo->query($sql);
		$sql2 = "SELECT * FROM users WHERE username='".$_SESSION['uname']."'";
		$result2 = $pdo->query($sql2);
		}
		catch(PDOException $e){
			$error = "".$e->getMessage();
			include "error.html.php";
			exit();
		}
		
		$row = $result->fetch(); //array containing each field from users for the friend requestee
		$row2 = $result2->fetch(); //array containing each field from users for the user logged in
			
			
		try{ //checking if already friends
			$sql = "SELECT COUNT(*) FROM friends WHERE email='".$row2['email']."' AND emailF='".$row['email']."'";
			$result = $pdo->query($sql);
			$resNum = $result->fetchColumn();
		}
		catch(PDOException $e){
			$error = "".$e->getMessage();
			include "error.html.php";
			exit();
		}
		
		if($resNum==0){ //if they are not already friends
			//send an email
			$sqln = 'INSERT INTO friends SET
					 email="'.$row['email'].'",
					 emailF="'.$row2['email'].' "';
			$pdo->exec($sqln);
			$emailF = htmlspecialchars($row['email']);
			$email = htmlspecialchars($row2['email']);
			$usern = htmlspecialchars($_SESSION['uname']);
			include './mail/addFriendMail.php';
			
		}
		else {
			echo '<script>alert("That user is already in your friends list!");</script>';
		}
	}
	?>
	
	
	<div id="invFriendModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Invite Friend</h4>
		  </div>
		  <div class="modal-body">
				<form id = "addFriendForm" method="post">
					<div class = "input-group input-group-md"> 
						<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
						<input type="email" class="form-control" id="emailInv" name="emailInv" placeholder="Email Address" required="">
					</div>
					<button type="submit" class="btn btn-primary btn-block margTop" name="invS">Send Invitation!</button>
				</form>
		  </div>
		</div>
	  </div>
	</div>
	<?php
	if (isset($_POST['emailInv'])) {
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
		
		try{ //selecting the users
		$sql = "SELECT COUNT(*) FROM users WHERE email='".$_POST['emailInv']."'";
		$result = $pdo->query($sql);
		}
		catch(PDOException $e){
			$error = "".$e->getMessage();
			include "error.html.php";
			exit();
		}
		
		$resNum = $result->fetchColumn(); //number of rows with the email specified - should be 0 if new user
			
		if($resNum==0){ //if no registered email
			//send an email
			$emailRec = htmlspecialchars($_POST['emailInv']);
			$usern = htmlspecialchars($_SESSION['uname']);
			include './mail/invFriendMail.php';
			
		}
		else {
			echo '<script>alert("That user is already registered!");</script>';
		}
	}
	?>
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
	<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
	<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
	<script>
		$(document).ready(function(){
		$('[data-toggle="popover"]').popover();   
		});
	</script>
</body>