<!DOCTYPE html>
<html lang="en">
<head>
	<title>Change Avatar | Krisp</title>
		<script>
			function imgClC(x){
				var aList = document.getElementsByName("avatar");
				for (var i = 0; i < aList.length; i++) {
					aList[i].classList.remove("activeImgAv");
				}
				x.classList.add("activeImgAv");
				var splitStringArr = x.src.split("/");
				var splitLast = splitStringArr[splitStringArr.length-1];
				document.getElementById("sessionVar").value =splitLast;
			}
		</script>
</head>
<body>
	<div class="container-fluid">
		<h2>Choose an avatar</h2>
		<div class="row placeholders">
			<?php
				for($i=0; $i<2; $i++){
					echo '<div class="row chAvPad">';
					for($x=0; $x<4; $x++){
						echo '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						<img class="img-responsive img-circle imgPt" 
						onclick= "imgClC(this)"
						src="../imgs/'.(($i*4)+$x).'.png"
						name="avatar">
						</div>';
					}
					echo '</div>';
				}
			?>
		</div>
		<form id = "avChange" action="" method="post">
			<input type="hidden" name="sessionVar" id="sessionVar" value=""></input>
			<button type="submit" class="btn btn-success btn-lg" name="chAv">Confirm</button>
		</form>
		<?php 
			if(isset($_POST['sessionVar'])){
				$apng = $_POST['sessionVar'];
				echo '<script>document.getElementById("avLabel").src="../imgs/' .$apng. '";</script>';
				$apngSplit = explode('.', $apng, 2);
				$_SESSION['icon']=$apngSplit[0];
				//echo $apng."<BR>";
				//echo $apngSplit[0]."<BR>";
				//echo $apngSplit[1]."<BR>";
				//echo $_SESSION['icon']."<BR>";
				
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
				
				try{
					$sql = "UPDATE userprofile SET iconNum = '".$_SESSION['icon']."' WHERE userprofile.email = '".$row['email']."'";
					$result = $pdo->exec($sql);
					$output = "Avatar changed successfully!";
					echo '<BR>';
					include 'output.html.php';
				}
				catch(PDOException $e){
					$error = "".$e->getMessage();
					include "error.html.php";
					exit();
				}
				
				
			}
		?>
	</div>
</body>