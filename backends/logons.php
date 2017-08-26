<?php
//Members log in
$next = 'index.php';
$logged = 'True';
if(isset($_POST['log_submit']))
{
  // die(var_dump($logged));
    if($main->login('members',array('login','password','id',$logged),array($_POST['login'],$_POST['password']))=='true')
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
//Members Registration
if(isset($_POST['reg_submit']))
{
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
  if(!count($msg))
  {
      $firstname = trim($_POST['firstname']);
      $lastname = trim($_POST['lastname']);
      $email = trim($_POST['email']);
      $password = $_POST['password'];
      $conf_mail = $con->prepare("select 1 from members where email = :mail");
      $conf_mail->execute(array(':mail'=>$email));
      if(!$conf_mail->fetch())
      {
      $conf_mail2 = $con->prepare("select 1 from members where email = :mail");
      $conf_mail2->execute(array(':mail'=>$email));
      if(!$conf_mail2->fetch())
      {
        $password = crypted($password);
        $do_insert = $con->prepare('insert into members(firstname,lastname,email,password,date) values(?,?,?,?,"'.date("Y-m-d H:i:s").'")');
        if($do_insert->execute(array($firstname,$lastname,$email,$password)))
        {
          $msg[]='You have successfully registered on '.ucwords($sitename).' ';
          $aid = $con->lastInsertId();
          if(Main::setUser('user',$aid,'members'))
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
        $msg[]="Member with this email already exists!";
      }
      }
      else
      {
        $msg[]="Member with this email already exists!";
      }
  }
}
//Function to select anything from teh database
function getDBString($tbname,array $columns = ["*"],$extras="")
{
  $data = [];
  $clname = implode(",",$columns);
  $doQ = $con->prepare("select $clname from $tbname $extras");
  if(!$doQ->rowCount()) return false; 
  while($row = $doQ->fetch())
  {
    $data[] = $row;
  }
  return $data;
}
?>