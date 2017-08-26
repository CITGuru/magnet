<?php
error_reporting(0);
require '../incs/index.php';
if(isset($_POST)&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=='xmlhttprequest')
{
	if(isset($authed)&&isset($typed)&&$_POST['doIs'])
	{
		$doIs = (int)$_POST['doIs'];
		$typee = (String)$_POST['typee'];
		$aTt = (String)$_POST['aTt'];
		$aOw = (String)$_POST['aOw'];
		$pur_link = (String)$typee."/".$doIs;
		$doLikes = $con->prepare("select 1 from likes where fromm = :fromm and article = :article and type = :type order by id desc limit 1");
		$doLikes->execute(array(':fromm'=>$typed."".$authed,':article'=>$doIs,':type'=>$typee));
		if($doLikes->rowCount())
		{
			//Do Unlikes
			$doUnlikes = $con->prepare("delete from likes where fromm = :fromm and article = :article and type = :type order by id desc limit 1");
			$doUnlikes->execute(array(':fromm'=>$typed."".$authed,':article'=>$doIs,':type'=>$typee));
			$getLikes = $con->prepare("select count(*) from likes where article = :article order by id desc");
			$getLikes->execute(array(':article'=>$doIs));
			$like_str = (String)$getLikes->fetch()[0];
			die($like_str);
		}
		else
		{
			$moreLikes = $con->prepare("insert into likes set fromm =:fromm, article =:article, type = :type, date = '".date("Y-m-d H:i:s")."' ");
			$moreLikes->execute(array(':fromm'=>$typed."".$authed, ':article'=>$doIs,':type'=>$typee));
			$insert_noti = $con->prepare("insert into notifications(fromm, too, purpose, purpose_link, date) values(:me,:you,:purpose,:pur_link,'".date("Y-m-d H:i:s")."')");
			$insert_noti->execute(array(':me'=>$typed."".$authed, ':you'=>$aOw, ':purpose'=> ' liked one of your '.$typee.' <b>'.ucwords($aTt).'</b>. ',':pur_link'=>$pur_link));
			$getLikes = $con->prepare("select count(*) from likes where article = :article and type = :type order by id desc");
			$getLikes->execute(array(':article'=>$doIs,':type'=>$typee));
			$like_str = (String)$getLikes->fetch()[0];
			die($like_str);
	}
}
}
?>
