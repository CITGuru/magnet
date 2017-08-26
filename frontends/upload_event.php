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
	<div class="container" style="width: 60%;">
		<div class="create_event_wrapper">
			<input type="text" name="event_name" class="form-control" id="event_name" placeholder="Event Name">
			<div class="input-group">
			<input type="text" name="venue" id="venue" class="form-control" placeholder="Venue's Name">
			<input type="text" name="address" id="address" class="form-control" placeholder="Address">
			<input type="text" name="city" id="city" class="form-control" placeholder="City">
			<input type="text" name="state" id="state" class="form-control" placeholder="State">
			<input type="text" name="postal" id="postal" class="form-control" placeholder="Postal">
			<input type="text" name="country" id="country" class="form-control" placeholder="Country">
			</div>
			<div>			
			 name="tickets_no" class="form-control" id="tickets_no">
			<input type="submit" name="" class="btn btn-danger" value="Create Event">
		</div> <label for="start_date">Start Date</label>
			<input type="date" name="start_date" class="form-control" id="start_date">
			<label for="start_time">Start Time</label>
			<input type="time" name="start_time" class="form-control" id="start_time">
			<label for="start_date">End Date</label>
			<input type="date" name="start_date" class="form-control" id="start_date">
			<label for="start_time">End Time</label>
			<input type="time" name="start_time" class="form-control" id="start_time">
			<textarea class="form-control" id="" placeholder="Description"></textarea>
			<input type="hidden" name="description" class="form-control" id="description">
			<label for="paid_tickets">Paid Ticket</label>
			<input type="checkbox" name="" class="form-control" id="paid_tickets">
			<label for="free">Free</label>
			<input type="checkbox" name="" class="form-control" id="free">
			<div class="event-image col-md-6" style="background-color: whitesmoke;display: block;">
				<input type="file" name="picture" class="form-control" value="upload event image">
			</div>
			<label for="tickets_name">Ticket Name</label>
			<input type="text" name="tickets_name" class="form-control" id="tickets_name">
			<label for="tickets_no">Ticket No</label>
			<input type="text" name="tickets_no" class="form-control" id="tickets_no">
			<label for="tickets_name">Ticket Name</label>
			<input type="text" name="tickets_name" class="form-control" id="tickets_name">
			<label for="tickets_no">Ticket No</label>
			<input type="text" name="tickets_no" class="form-control" id="tickets_no">
			<label for="event_categories">Event Categories</label>
			<input type="text" name="event_categories" class="form-control" id="event_categories">
			<label for="">Ticket No</label>
			<input type="text"
	</div>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>