<!DOCTYPE html>
<html lang="en">
<head>
	<title>Change Username | Krisp</title>
</head>
<body>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<h2>Change username</h2>
		<form id = "passChange" action="" method="post">
		<div class = "form-group"> 
			<!-- <label for="username">Username</label> -->
			<input type="text" class=form-control id="nUserN" name="nUserN" placeholder="New Username" required="">
		</div>
		<button type="submit" class="btn btn-primary btn-lg btn-block" name="chUser" >Confirm</button>
		</form>
	</div>
	
		<?php
		if (isset($_POST['nUserN'])) {
			if($_POST['nUserN'] == $_SESSION['uname']){
				$error = 'Username is already in use!';
				include 'error.html.php';
			}
			else{
				try{
					$sql = "SELECT * FROM users WHERE username='".$_POST['nUserN']."'";
					$result = $pdo->query($sql);
					$rowNum = $result->fetchColumn();
				}
				catch(PDOException $e){
					$error = "".$e->getMessage();
					include "error.html.php";
					exit();
				}
				
				if($rowNum==0){
					$sql = "UPDATE users SET username = '".$_POST['nUserN']."' WHERE users.username = '".$_SESSION['uname']."'";
					$pdo->exec($sql);
					$_SESSION['uname'] = $_POST['nUserN'];
					//header ("Location:http://localhost/KrispFiles/actSettings/?user");
					$output = "Username changed successfully!";
					include 'output.html.php';
					echo '<script>document.getElementById("usernameLabel").innerHTML = "'.$_SESSION['uname'].'";</script>';
				}
				else{
					$error = 'Username is already in use!';
					include 'error.html.php';
				}
			}
		}
	?>
</body>