<?php
include 'confEmail.html';
if (isset($_GET['email']))
{
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
	
	try{
		$sql = "SELECT COUNT(*) FROM users WHERE email='".htmlspecialchars($_GET['email'])."'";
		$result = $pdo->query($sql);
		$resNum = $result->fetchColumn();
	}
	catch(PDOException $e){
		$error = "".$e->getMessage();
		include "error.html.php";
		exit();
	}
	if($resNum==0){
		$error = "No email in database!";
		include "error.html.php";
	}
	else{
		$sql = "UPDATE users SET verified=1 WHERE email='".htmlspecialchars($_GET['email'])."'";
		$pdo->exec($sql);
		include "success.html.php";
	}
}
else {
	$error = "Link is broken!";
	include "error.html.php";
}
	
?>