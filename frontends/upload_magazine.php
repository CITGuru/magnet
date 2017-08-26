<?php
include '../../backends/incs/index.php';
include '../../backends/mag-book.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lovents | Your Personal Assistant Events Creator</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<div class="header">
	<div class="container-fluid">
		<div class="logo">
			<img src="../img/logo-lon.png">
		</div>
		<div class="nav large-nav-only">
			<ul class="navbar">
				<li><a href="">Home</a></li>
				<li><a href="">Create</a></li>
				<li><a href="">Login</a></li>
				<li><a href="">Register</a></li>
			</ul>
		</div>
		<div class="nav mobile-nav small-nav-only dropdown" style="display: none;">
			<a class="dropdown-toggle" class="btn btn-info" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" style="overflow: hidden;"><i class="fa fa-align-justify"></i></a>
			<ul class="navbar dropdown-menu">
				<li><a href="">Home</a></li>
				<li><a href="">Upload</a></li>
				<li><a href="">Login</a></li>
				<li><a href="">Register</a></li>
			</ul>
		</div>
	</div>
</div>
<div class="content-wrapper">
	<div class="container ">
		<input type="text" name="title" class="form-control">
		<div class="description">
			<textarea class="form-control"></textarea>
			<input type="hidden" name="description">
		</div>
		<input type="file" name="" value="Front Cover">
		<input type="file" name="" value="Back Cover">
		<button class="btn btn-danger"><i class="fa fa-plus"></i> Add Page</button>
		<div class="input-group">
			<input type="file" name="picture">
		</div>

	</div>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>