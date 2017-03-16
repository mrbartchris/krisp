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

include 'logreg.html';

/*
try {
	$sql = 'CREATE TABLE users (
				username varchar(128) not null primary key,
				password varchar(128) not null
			) default character set utf8 engine = InnoDB';
			$pdo->exec($sql);
}
catch (PDOException $e){
	$output = 'Error creating table: '.$e->getMessage();
	include 'output.html.php';
	exit();
}
*/

//LOGIN

if (isset($_GET['login'])) 
{
 include 'login.html';
	 if(isset($_COOKIE['oreo']) && isset($_COOKIE['pb'])){
		try{
			$sql = "SELECT * FROM users WHERE username='".$_COOKIE['oreo']."'";
			$result = $pdo->query($sql);
		}
		catch(PDOException $e){
			$error = "".$e->getMessage();
			include "error.html.php";
			exit();
		}
		
		$row = $result->fetch();
		if($row['password'] == $_COOKIE['pb']) {
			try{
				$sql1 = "SELECT * FROM userprofile WHERE email='".$row['email']."'";
				$result1 = $pdo->query($sql1);
				$sql2 = "UPDATE userprofile SET status = '1' WHERE userprofile.email = '".$row['email']."'";
				$pdo -> exec($sql2);
			}
			catch(PDOException $e){
				$error = "".$e->getMessage();
				include "error.html.php";
				exit();
			}
			$row1 = $result1->fetch();
			session_start();
			$_SESSION['uname'] = $row['username'];
			$_SESSION['icon']=$row1['iconNum'];
			header("Location:http://localhost/KrispFiles/landing.html.php");
		}
	 }
 
  exit();
}
if (isset($_POST['username']) && isset($_POST['password']) && !isset($_POST['password2'])){
	try{
		$sql = "SELECT * FROM users WHERE username='".$_POST['username']."'";
		$result = $pdo->query($sql);
	}
	catch(PDOException $e){
		$error = "".$e->getMessage();
		include "error.html.php";
		exit();
	}
	
	$row = $result->fetch();
	if($row['password'] == $_POST['password']) {
		if($row['verified'] == 0){
			$error = "Account is not yet verified!";
			include 'error.html.php';
		}
		else{
			if(isset($_POST['chkbx'])){
				setcookie("oreo",$_POST['username'],time()+31536000);
				setcookie("pb",$_POST['password'],time()+31536000);
			}
			try{
				$sql1 = "SELECT * FROM userprofile WHERE email='".$row['email']."'";
				$result1 = $pdo->query($sql1);
				$sql2 = "UPDATE userprofile SET status = '1' WHERE userprofile.email = '".$row['email']."'";
				$pdo -> exec($sql2);
			}
			catch(PDOException $e){
				$error = "".$e->getMessage();
				include "error.html.php";
				exit();
			}
			$row1 = $result1->fetch();
			session_start();
			$_SESSION['uname'] = $row['username'];
			$_SESSION['icon']=$row1['iconNum'];
			header("Location:http://localhost/KrispFiles/landing.html.php");
		}
	}
	else if (!$row['password'] || !$row['username']) {
		$error = "Username does not exist!";
		include 'error.html.php';
	}
	else {
		$error = "Incorrect password!";
		include 'error.html.php';
	}
	
	
	/*
	foreach($result as $row){
		echo "RAD: ".htmlspecialchars($row['username'],ENT_QUOTES,'UTF-8')."<BR>";
		if(htmlspecialchars($row['username'],ENT_QUOTES,'UTF-8') == $_POST['username']){
			$output = "Hello ".$_POST['username']."!";
			$username = "".$_POST['username'];
		}
	}
	include 'output.html.php';
	*/
}



//REGISTER

if (isset($_GET['register'])) 
{
 include 'register.html';
  exit();
}
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['email']))
	{
	
	if(($_POST['password'] == $_POST['password2'])){
		try{
			$sql = "SELECT COUNT(*) FROM users WHERE username='".$_POST['username']."'";
			$result = $pdo->query($sql);
			$resNum = $result->fetchColumn();
		}
		catch(PDOException $e){
			$error = "".$e->getMessage();
			include "error.html.php";
			exit();
		}
		
		if($resNum==0){
			try{
				$sql = "SELECT COUNT(*) FROM users WHERE email='".$_POST['email']."'";
				$result = $pdo->query($sql);
				$resNum = $result->fetchColumn();
			}
			catch(PDOException $e){
				$error = "".$e->getMessage();
				include "error.html.php";
				exit();
			}
			
			if($resNum==0){		
				$sql = 'INSERT INTO users SET
				 username="'.$_POST['username'].'",
				 password="'.$_POST['password'].'",
				 email="'.$_POST['email'].'";
				 INSERT INTO userprofile SET
				 email="'.$_POST['email'].'"';
				$pdo->exec($sql);
				$mtosend = htmlspecialchars($_POST['email']);
				include './mail/mail.php';
				header("Location:http://localhost/KrispFiles/?regValidate");				
			}
			else {
				$error = 'Email already in use!';
				include 'error.html.php';
			}
		}
		else {
			$error = 'Username is already taken!';
			include 'error.html.php';
		}
	}
	else {
		$error = 'Passwords do not match!';
		include 'error.html.php';
	}
}

if (isset($_GET['regValidate']))
{
 include 'regVal.html';
  exit();
}

$pdo = null;