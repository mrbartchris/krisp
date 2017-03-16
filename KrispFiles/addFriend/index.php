<?php
include 'addFriendPage.html';
if (isset($_GET['frec']) && isset($_GET['fsend']))
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
		$sql = "SELECT COUNT(*) FROM users WHERE email='".htmlspecialchars($_GET['fsend'])."'";
		$result = $pdo->query($sql);
		$resNum = $result->fetchColumn();
		$sql2 = "SELECT COUNT(*) FROM users WHERE email='".htmlspecialchars($_GET['frec'])."'";
		$result2 = $pdo->query($sql2);
		$resNum2 = $result2->fetchColumn();
		
	}
	catch(PDOException $e){
		$error = "".$e->getMessage();
		include "error.html.php";
		exit();
	}
	if($resNum==0 || $resNum2==0){
		$error = "No email in database!";
		include "error.html.php";
	}
	else{
		try{
			$sqlX = "SELECT COUNT(*) FROM friends WHERE email='".htmlspecialchars($_GET['fsend'])."' AND emailF='".htmlspecialchars($_GET['frec'])."'";
			$resultX = $pdo->query($sqlX);
			$resNumX = $resultX->fetchColumn();
		}
		catch(PDOException $e){
			$error = "".$e->getMessage();
			include "error.html.php";
			exit();
		}
		if($resNumX == 0){
			$sql = 'INSERT INTO friends SET
					 email="'.htmlspecialchars($_GET['fsend']).'",
					 emailF="'.htmlspecialchars($_GET['frec']).' "';
			$pdo->exec($sql);
			include "success.html.php";
		}
		else {
			$error = "Friend is already added!";
			include "error.html.php";
		}
	}
}
else {
	$error = "Link is broken!";
	include "error.html.php";
}
	
?>