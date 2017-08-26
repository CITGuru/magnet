<?php
include '../backends/incs/index.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Magnet | Online Magazine Platform</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php echo $head; ?>
	<div class="banner-wrapper" style="background-image: url(img/slide-lovent.png);">
		<div class="container banner">
			<div class="banner-text col-md-12">
				<h3 class="text-center" style="color: white;">Read Various Online Magazine</h3>
			
			<form class="search-box" method="get" action="/search">
			<div class="input-group">
            	<input type="text" class="form-control col-md-4" placeholder="Search for Magazines" name="q" required="">
            	<select class="form-control col-md-4" name="op" value="All" style="color: black;">
            		<option selected="">All</option>
            		<option>Business</option>
            		<option>Fashion</option>
            		<option>Sport</option>
            		<option>Tech</option>
            	</select>
                <span class="input-group-btn">
                	<button class="btn btn-default" type="submit"><i class="fa fa-search" name="search-btn"></i></button>
           	    </span>
            </div>
            </form>
            </div>
		</div>
	</div>
<div class="strip-banner">
	<div class="container">
		<ul>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>

<div class="content-wrapper">
	
</div>
<div class="footer-wrapper">
	<div class="footer">
		
	</div>
<div>
</div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>