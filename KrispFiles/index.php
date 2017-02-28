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
			session_start();
			$_SESSION['uname'] = $row['username'];
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
		if(isset($_POST['chkbx'])){
			setcookie("oreo",$_POST['username'],time()+31536000);
			setcookie("pb",$_POST['password'],time()+31536000);
		}
		session_start();
		$_SESSION['uname'] = $row['username'];
		header("Location:http://localhost/KrispFiles/landing.html.php");
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

if (isset($_GET['register']))
{
 include 'register.html';
  exit();
}
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']))
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
			$sql = 'INSERT INTO users SET
			 username="'.$_POST['username'].'",
			 password="'.$_POST['password'].'"';
			$pdo->exec($sql);
			header("Location:http://localhost/KrispFiles/?login");
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

$pdo = null;