<?php
include '../backends/incs/index.php';
include '../backends/logons.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Magnet | Login</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="background-image: url(img/slide-lovent.png);background-size: cover;">
<?php echo $head; ?>
<div class="content-wrapper" style="padding-top: 100px;">
	<div class="container" style="width: 40%;">
		<div class="login-registration-wrapper col-md-12">
			<form method="post" class="form-group" style="margin-bottom: 0px;">
				<div class="input-group">
                    <i class="input-group-addon fa fa-envelope-o"></i>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required="" />
                </div>
				<div class="input-group">
					<i class="input-group-addon fa fa-lock"></i>
					<input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
				</div>
				<input type="submit" name="log_submit" class="btn btn-danger" value="Login">
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>