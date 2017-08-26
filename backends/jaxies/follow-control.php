<?php
error_reporting(0);
require '../incs/index.php';
if(isset($_POST)&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=='xmlhttprequest')
{
	if(isset($authed)&&isset($typed)&&$_POST['doIs'])
	{
		if($_POST['doIs']!=$typed."".$authed)
		{
		$doIs = (String)$_POST['doIs'];
		$pur_link = $typed.'/'.$authed;
		$doFollow = $con->prepare('select 1 from followers where follower = :me and followed = :you limit 1');
		$doFollow->execute(array(':me'=>$typed."".$authed,':you'=>$doIs));
		if($doFollow->rowCount())
		{
			//Delete follow
			$delete = $con->prepare("delete from followers where follower = :me and followed = :you limit 1");
			$delete->execute(array(':me'=>$typed."".$authed,':you'=>$doIs));
			$insert_noti = $con->prepare("insert into notifications(fromm, too, purpose, purpose_link, date) values(:me,:you,:purpose,:pur_link,'".date("Y-m-d H:i:s")."')");
			$insert_noti->execute(array(':me'=>$typed."".$authed, ':you'=>$doIs, ':purpose'=> ' unfollowed you ', ':pur_link'=>$pur_link));
			die('Follow');
		}
		else
		{
			$create_new = $con->prepare("insert into followers set follower = :me, followed = :you ");
			if($create_new->execute(array(':me'=>$typed."".$authed,':you'=>$doIs)))
			{
			$insert_noti = $con->prepare("insert into notifications(fromm, too, purpose, purpose_link, date) values(:me,:you,:purpose,:pur_link,'".date("Y-m-d H:i:s")."')");
			$insert_noti->execute(array(':me'=>$typed."".$authed, ':you'=>$doIs, ':purpose'=> ' followed you ', ':pur_link'=>$pur_link));
				die('Following');
			}

		}
	}
}
else
{
	die('Follow');
}
}
?>
