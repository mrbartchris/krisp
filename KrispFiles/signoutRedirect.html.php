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