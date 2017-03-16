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
session_start();
if(isset($_SESSION['uname'])){
	try{
		$sql = "SELECT * FROM users WHERE username='".$_SESSION['uname']."'";
		$result = $pdo->query($sql);
	}
	catch(PDOException $e){
		$error = "".$e->getMessage();
		include "error.html.php";
		exit();
	}
	$row = $result->fetch();
	try{
		$sql2 = "UPDATE userprofile SET status = '0' WHERE userprofile.email = '".$row['email']."'";
		$pdo -> exec($sql2);
	}
	catch(PDOException $e){
		$error = "".$e->getMessage();
		include "error.html.php";
		exit();
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="refresh" content="1; url=http://localhost/KrispFiles/?login">
	<title>Signing Out</title>
</head>
<body>
	<p>
		<?php 
			setcookie("oreo","",time()-3600);
			setcookie("pb","",time()-3600);
			header("Location: http://localhost/KrispFiles/?login");
		?>
	</p>
	<p><a href="http://localhost/KrispFiles/?login">Press to redirect if your browser does not redirect automatically</a></p>
	<script type="text/javascript">
		window.location.href = "http://localhost/KrispFiles/?login"
	</script>
</body>
</html>