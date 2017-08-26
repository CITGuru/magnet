<?php
error_reporting(0);
$h = ' head ';
require 'incs/index.php';
$id = (int)$_GET['pid'];
$gevents = $con->prepare("select * from events where id=? limit 1");
$gevents->execute(array($id));
if(!$gevents->rowCount())
{
	header("Location:./");
	exit;
}
$geventsRes = $gevents->fetch(PDO::FETCH_OBJ);
$id = $geventsRes->id;
$name = $geventsRes->name;
$body = $geventsRes->description;
$address = $geventsRes->address;
$city = $geventsRes->city;
$state = $geventsRes->state;
$country = $geventsRes->country;
$postal = $geventsRes->postal;
$start_date = $geventsRes->start_date;
$start_time = $geventsRes->start_time;
$end_date = $geventsRes->end_date;
$end_time = $geventsRes->end_time;
$descr = $geventsRes->description;
$tags = $geventsRes->tags;
$pictures = $geventsRes->pictures;
$pic1 = explode(",",$pictures)[0];
$ticket_name  = $geventsRes->ticket_name;
$ticket_no  = $geventsRes->ticket_no;
$ticket_price  = $geventsRes->ticket_price;
$organizers    = $geventsRes->organizers;
$venue_name    =  $geventsRes->venue_name
$paid_ticket = $geventsRes->paid_ticket=='true'?true:false;
$iid = $geventsRes->iid;
$date = $geventsRes->date;
$getOwner = $con->prepare("select id, email,title,firstname,lastname,picture from $itype where id=? limit 1");
$getOwner->execute(array($iid));
if(!$getOwnerRes = $getOwner->fetch(PDO::FETCH_OBJ))
{
	// echo '<p>Sorry, error occured while fetching Owner Profile</p>';
}
else
{
	$oid = $getOwnerRes->id;
	$otitle = $getOwnerRes->title;
	$ofname = $getOwnerRes->firstname;
	$olname = $getOwnerRes->lastname;
	$ologin = $getOwnerRes->login;
	$ooccu = $getOwnerRes->occupation;
	$opicture = $getOwnerRes->picture;
	$oaddress = $getOwnerRes->address;
	$oabout = $getOwnerRes->about;
	$ocategories = $getOwnerRes->categories;
	$ointerest = $getOwnerRes->interest;
}
$getLikes = $con->prepare("select count(*) from likes where article = :article and type = 'events' order by id desc limit 1");
$getLikes->execute(array(':article'=>$id));
$like_str = $getLikes->fetch()[0];
$like_str = $like_str==0?"":$like_str." ";
if(!$mine&&$ftype=='investors')
{
if(isset($_POST['sendpro']))
{
	$intro = $_POST['intro'];
	$foot =$_POST['foot'];
	$content = $_POST['mail'];
	if($intro&&$foot&&$content)
	{
	$toMail=$oaddress;
	$headers='';
	$headers.= "From: <no-reply@vestub.com> Vestub\r\n";
	$headers.= "\r\nReply-To: no-reply@vestub.com";
	$headers.= "\r\nX-Mailer: PHP/".phpversion();
	$headers.="MIME-Version: 1.0 \r\n";
	$headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
	$subj="An Investor is Interested in your event";
	$body="<!DOCTYPE html><html><head><link rel='stylesheet' href='{$web}css/mails.css' type='text/css' /></head><body>".ucfirst($intro).$content.ucfirst($foot)."</body></html>";
	if(mail($toMail,$subj,$body,$headers))
	{
		$succ = TRUE;
		$msg[]='Your proposal has been sent to owner\'s mail, they will get back to you as soon as possible - thanks.';
	}
	else
	{
		$msg[]='Sorry, error occured, mail not sent!';
	}
	}
}
}
if(isset($authed))
{
	//Check if comment is submitted
	if(isset($_POST['post_my_comment'])&&$_POST['my_comment'])
	{
		$coms = $_POST['my_comment'];
		$post_now = $con->prepare("insert into comments(body,iid,iiid,itype,date) values(?,?,?,?,?)");
		$post_now->execute(array($coms,$id,$ftype.$fid,'events',date("Y-m-d H:i:s")));
		header("Refresh:0");
		exit;

	}
}
?>