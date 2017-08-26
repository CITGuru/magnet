<?php
//header to construction
// header("Location:coming-soon.html");
// exit;
error_reporting(0);
session_start();
$inc2_src = '../../frontends/';
if(isset($_COOKIE['user'])||isset($_SESSION['user']))
{
  // die("1. {$_COOKIE['user']} 2. {$_SESSION['user']}");
  $authed = $_COOKIE['user']?$_COOKIE['user']:$_SESSION['user'];
}
if(isset($_COOKIE['type'])||isset($_SESSION['type']))
{
  $typed = $_COOKIE['type']?$_COOKIE['type']:$_SESSION['type'];
}
require 'classes.php';
if($_SERVER['HTTP_HOST']=='localhost'||$_SERVER['HTTP_HOST']=="127.0.0.1"){
  $host='localhost';
  $dbname='magnet';
  $dbuser='root';
  $dbpass='admin'; 
  $u='http://localhost/challenge/';
  $sitename = "Vestub";  
  $base = '/magnet/';
  $web = 'http://localhost/magnet/';
}
else
{
  $u='https://vestub.com/';
  $host='db682746793.db.1and1.com';
  $dbname='db682746793';
  $dbuser='dbo682746793';
  $dbpass='challengedocument';
  $u='https://vestub.com/';
  $sitename = "Vestub";  
  $base = '/';
  $web = 'https://vestub.com/';
}
$owner = 'Idea Owner';
$main=new Main($host,$dbname,$dbuser,$dbpass);
$iphone = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("iPhone"));
$android = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("Android"));
$palmpre = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("webOS"));
$berry = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("BlackBerry"));
$ipod = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("iPod"));
$operaM = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("opera mini"));
$operaM2 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("Opera Mini"));
$operaM3 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("mini"));
$operaM4 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("Mini"));
$operaM5 = strpos(strtolower($_SERVER['HTTP_USER_AGENT']),strtolower("Opera Mobi"));
$mobiley=false;
$op = false;
if($iphone||$android||$palmpre||$berry||$ipod||$operaM||$operaM2||$operaM3||$operaM4||$operaM5)
{
    $mobiley=true;
}
if($operaM||$operaM2||$operaM3||$operaM4||$operaM5)
{
    $op=true;
}
/* --- Functions -- */
function detox($string)
{
    return preg_replace(array('/\[[a-z0-9]+\]/is','/\[\/[a-z0-9]+\]/is'),array('',''),$string);
}
function trunc_str($str,$len=20)
{
    if(strlen($str)>$len) $str=substr($str,0,$len-3)."..."; return $str;
}
function is_mail($_m)
{
  return (preg_match('/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9]+(\.[a-z0-9]+)*(\.[a-z]{2,3})/is',$_m));
}
function crypted($str,$len=22)
{
        $salt = "$2y$12$".substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,$len);
        return crypt($str,$salt);
}
function speak_date($time)
{
    return $time;
}
function speak_peach($video)
{
  if(preg_match('/^(https?:\/\/).+/is',$video))
  {
    return "<div class='my_vid'>
    <iframe width='854' height='480' src='$video' frameborder='0' allowfullscreen></iframe>
    </div>";
  }
  else
  {
    return "
    <div class='my_vid'>
    <video controls>
    <source src='prof_videos/".urlencode($video)."' />
    </video>
    </div>
    ";
  }
}
/* --- Functions -- */
if(isset($authed))
{
    $user = (int)$authed;
    $type = (String)$typed;

    $doQuery = $con->prepare("select * from $type where id=? limit 1");
    $doQuery->execute(array($user));
    if($doQueryRes=$doQuery->fetch(PDO::FETCH_ASSOC))
    {
      $fid = $doQueryRes['id'];
      $ffname = $doQueryRes['firstname'];
      $flname = $doQueryRes['lastname'];
      $ftype = $doQueryRes['type'];
      $flogin = $doQueryRes['email'];
      $fabout = $doQueryRes['about'];
      $faddress - $doQueryRes['address'];
      if($ftype=='investors')
        
      {
        $fcomp = $doQueryRes['company'];
      }
      else if($ftype=='owners')
      {

      }
      $fpict = $doQueryRes['picture'];
      $fphone = $doQueryRes['phone'];
    
    $fdate = $doQueryRes['date'];
}
}
$logo = $isHome?'logo.png':'logo2.png';
$head = '<div class="header">
<div class="container-fluid">
    <div class="logo">
      <img src="img/logo-lon.png">
    </div>
    <div class="nav large-nav-only">
      <ul class="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="event-public.php">Explore</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      </ul>
    </div>
    <div class="nav mobile-nav small-nav-only dropdown" style="display: none;">
      <a class="dropdown-toggle" class="btn btn-info" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" style="overflow: hidden;"><i class="fa fa-align-justify"></i></a>
      <ul class="navbar dropdown-menu">
        <li><a href="">Home</a></li>
        <li><a href="">Upload</a></li>
        ';

if(isset($authed))
  {
    $head.='<li><a href="account.php">My Account</a></li>';
            $get_noti = $con->prepare("select * from notifications where too = :too and status = 'unread' order by id desc limit 5");
              $get_noti->execute(array(':too'=>$typed."".$authed));
            $noti_num = $get_noti->rowCount()?$get_noti->rowCount():"";
          $head.='<li class="notifications dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" style="overflow: hidden"><i class="fa fa-bell"></i></a>
          <span class="informer informer-noti">'.$noti_num.'</span>
            <ul class="dropdown-menu noti-dropdown" onclick="noty({text: \'This alert needs your attention\', layout: \'topRight\', type: \'information\'});">';
            if(!$noti_num) 
              {
                $head.='<li class="dropli noti-li"><a class="noti-link">No new notifications yet.</a></li>';
              }
            while($get_noti_res = $get_noti->fetch(PDO::FETCH_OBJ))
            {
              $mysender = $get_noti_res->fromm;
              $purpose = $get_noti_res->purpose;
              $noti_date = $get_noti_res->date;
              $noti_id   = $get_noti_res->id;
              $noti_link = $get_noti_res->purpose_link;
              $sender_type = preg_replace('/\d+/is', '', $mysender);
              $sender_id = preg_replace('/[a-z]+/is', '', $mysender);
              $get_sender_profile = $con->prepare("select title, firstname, lastname from $sender_type where id=:id limit 1");
              $get_sender_profile->execute(array(':id'=>$sender_id));
              $get_sender_profile_res = $get_sender_profile->fetch(PDO::FETCH_OBJ);
              $sender_title = ucwords($get_sender_profile_res->title." ".$get_sender_profile_res->firstname." ".$get_sender_profile_res->lastname);
            $head.='<li class="dropli noti-li"><a href="notifications?noti_link='.$noti_link.'&noti_id='.$noti_id.'">'.$sender_title." ".$purpose."<br/><span class='noti-time'>".date("d F, Y \a\\t h:i a",strtotime($noti_date)).'</span></a></li>';

          }
            $head.='</ul>
          </li>
  <style type="text/css">
    li.profile
    {
      background-image: url(\''.$web.'prof_images/thumb_'.$fpict.'\')
    }

  </style>
          ';
  }
  else
  {
    $head.='<li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>';
  }
$head.='</ul>
    </div>
  </div>
</div>';
$footer = '<div class="footer overflow-hidden"><div class="footer-body"><p>© 2017 '.ucfirst($sitename).'. All Rights Reserved</p></div></div>';
//$hk = '<span class="dropspan pull-right" style="display:none;"><ul class="dropmenu"></ul></span>'
$ds = DIRECTORY_SEPARATOR;
$noti_plugin = '<script type="text/javascript" src="js/jquery.noty.js"></script><script type="text/javascript" src="js/default.js"></script><script type="text/javascript" src="js/topRight.js"></script>';
?>