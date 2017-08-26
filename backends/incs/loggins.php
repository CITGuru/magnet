<?php
//Idea Owners
if(isset($_POST['own_log_submit']))
{
  $logged = isset($_POST['loggedin'])&&$_POST['loggedin']=='loggedin'?'True':'False';
  // die(var_dump($logged));
    if($main->login('owners',array('login','password','id',$logged),array($_POST['login'],$_POST['password']))=='true')
  {
    $rurl = (String)$_GET['next']?(String)$_GET['next']:'home';
    header("Location:".$rurl);
    exit;
  }
  else
  {
    $msg[]='Sorry error logging you in as our registered Idea Owner';
  }
}
//Investors submit
if(isset($_POST['inv_reg_submit']))
{
  if(!preg_match('/^[a-z]+$/is',trim($_POST['title'])))
  {
      $msg[]='Please provide a valid title E.g (Mr/Mrs).';
  }
  if(!preg_match('/^[a-z]{2,}\W*([a-z]{2,})?$/is',trim($_POST['firstname'])))
  {
      $msg[]='Please provide a valid firstname';
  }
  if(!preg_match('/^[a-z]{2,}\W*([a-z]{2,})?$/is',trim($_POST['lastname'])))
  {
      $msg[]='Please provide a valid lastname';
  }
  if(!is_mail($_POST['email']))
  {
      $msg[]='Please provide a valid email address';
  }
  if(strlen($_POST['password'])<8)
  {
      $msg[]='Minimal length of eight characters (8)';
  }
  if($_POST['city']&&strlen($_POST['city'])<2)
  {
      $msg[]='Please provide your own city';
  }
  if(!preg_match('/^[a-z\s]+$/is', $_POST['country'])||$_POST['country']=='country')
  {
      $msg[]='Please select your own country';
  }
  if(!count($msg))
  {
      $title = ucfirst(trim($_POST['title']).".");
      $firstname = trim($_POST['firstname']);
      $lastname = trim($_POST['lastname']);
      $email = trim($_POST['email']);
      $password = $_POST['password'];
      $city = trim($_POST['city']);
      $country = trim($_POST['country']);
      $conf_mail = $con->prepare("select 1 from investors where login = :mail");
      $conf_mail->execute(array(':mail'=>$email));
      if(!$conf_mail->fetch())
      {
      $conf_mail2 = $con->prepare("select 1 from owners where login = :mail");
      $conf_mail2->execute(array(':mail'=>$email));
      if(!$conf_mail2->fetch())
      {
        $password = crypted($password);
        $do_insert = $con->prepare('insert into investors(title,firstname,lastname,login,password,city,country,date) values(?,?,?,?,?,?,?,"'.date("Y-m-d H:i:s").'")');
        if($do_insert->execute(array($title,$firstname,$lastname,$email,$password,$city,$country)))
        {
          $msg[]='You have successfully registered as an Investor';
          $aid = $con->lastInsertId();
          if(Main::setUser('user',$aid,'investors'))
          {
              header("Location:$next");
              exit;
          }
        }
        else
        {
          $msg[]='Sorry, error occured';
        }
      }
      else
      {
        $msg[]="User with this email already exists!";
      }
      }
      else
      {
        $msg[]="User with this email already exists!";
      }
  }
}
?>