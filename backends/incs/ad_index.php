<?php
$get_profile = $con->prepare("select id, admin_name, admin_rank, admin_pic, admin_email, admin_phone, admin_about, admin_facebook, admin_twitter, admin_website, admin_degree, date from admin where id=? limit 1");
$get_profile->execute(array($_SESSION['admin']));
if($get_profile_res = $get_profile->fetch(PDO::FETCH_OBJ))
{
	$id = $get_profile_res->id; 
	$name = $get_profile_res->admin_name; 
	$rank = $get_profile_res->admin_rank; 
	$pic = $get_profile_res->admin_pic; 
	$email = $get_profile_res->admin_email; 
	$phone = $get_profile_res->admin_phone; 
	$about = $get_profile_res->admin_about; 
	$facebook = $get_profile_res->admin_facebook; 
	$twitter = $get_profile_res->admin_twitter; 
	$website = $get_profile_res->admin_website; 
	$degree = $get_profile_res->admin_degree;
}
?>