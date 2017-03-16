<!DOCTYPE html>
<html lang="en">
<head>
	<title>Change Password | Krisp</title>
</head>
<body>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<h2>Change password</h2>
		<form id = "passChange" action="" method="post">
		<div class = "form-group"> 
			<!-- <label for="username">Username</label> -->
			<input type="password" class=form-control id="opass" name="opass" placeholder="Old Password" required="">
		</div>
		<div class = "form-group"> 
			<!-- <label for="password">Password</label> -->
			<input type="password" class=form-control id="passwordN" name="passwordN" placeholder="New Password" required="">
		</div>
		<div class = "form-group"> 
			<!-- <label for="password">Password</label> -->
			<input type="password" class=form-control id="passwordN2" name="passwordN2" placeholder="Confirm Password" required="">
		</div>
		<button type="submit" class="btn btn-primary btn-lg btn-block" name="chPass" >Confirm</button>
		</form>
	</div>
	<?php
		if (isset($_POST['opass']) && isset($_POST['passwordN']) && isset($_POST['passwordN2'])) {
			if(($_POST['passwordN'] == $_POST['passwordN2'])){
				try{
					$sql = "SELECT * FROM users WHERE username='".$_SESSION['uname']."'";
					$result = $pdo->query($sql);
					$row = $result->fetch();
				}
				catch(PDOException $e){
					$error = "".$e->getMessage();
					include "error.html.php";
					exit();
				}
				
				if($row['password'] == $_POST['opass']){
					$sql = "UPDATE users SET password = '".$_POST['passwordN']."' WHERE users.username = '".$_SESSION['uname']."'";
					$pdo->exec($sql);
					$output = "Password changed successfully!";
					include 'output.html.php';
				}
				else{
					$error = 'Incorrect Password!';
					include 'error.html.php';
				}
			}
			else {
				$error = 'Passwords do not match!';
				include 'error.html.php';
			}
		}
	?>
</body>