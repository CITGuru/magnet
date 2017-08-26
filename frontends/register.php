<?php
include '../backends/incs/index.php';
include '../backends/logons.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lovents | Your Personal Assistant Events Creator</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="background-image: url(img/slide-lovent.png);background-size: cover;">
<?php echo $head; ?>
<div class="content-wrapper">
	<div class="container" style="width: 40%;">
		<div class="login-registration-wrapper col-md-12 register">
		<?php if(count($msg)>0) {$count=count($msg); if($succ) {$s=' succ ';} echo '<ul class="alert '.$s.'">'; foreach($msg as $e) { echo "<li>$e</li>";} echo '</ul>';}?>
			<form method="post" class="form-group" style="margin-bottom: 0px;">
				<input type="text" name="firstname" class="form-control" id="first_name" placeholder="First Name">
				<input type="text" name="lastname" class="form-control" id="last_name" placeholder="Last Name">
				<input type="email" name="email" class="form-control" id="email" placeholder="Email">
				<input type="password" name="password" class="form-control" id="password" placeholder="Password">
				<input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="Conform password">
				<input type="submit" name="reg_submit" class="btn btn-danger" value="Create Account">
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>