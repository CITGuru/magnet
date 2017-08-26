<?php
require 'incs/index.php';
//Event booking
if(isset($_POST['publish']))
{
$u_str = 'insert into mags ';
if(isset($_GET['pid']))
{
	$getContents = $con->prepare("select * from mags where id=:pid and iid=:fid limit 1");
	$getContents->execute(array(':fid'=>$fid,':pid'=>(int)$_GET['pid']));
	if($getContentsRes = $getContents->fetch(PDO::FETCH_OBJ))
	{
		$name=$getContentsRes->name;
		$body=$getContentsRes->description;
		$street = $geventsRes->street;
		$city = $geventsRes->city;
		$state = $geventsRes->state;
		$country = $geventsRes->country;
		$start_date = $geventsRes->start_date;
		$start_time = $geventsRes->start_time;
		$end_date = $geventsRes->end_date;
		$end_time = $geventsRes->end_time;
		$ticket_name = $geventsRes->ticket_name;
		$ticket_no = $geventsRes->ticket_no;
		$ticket_price = $geventsRes->ticket_price;
		$tags=$getContentsRes->tags;
		$pictures=$getContentsRes->pictures;
		$pic1 = explode(",",$pictures)[0];
		$paid_ticket=$getContentsRes->paid_ticket;
		$u_str = 'update events ';
		$u_wh = ' where iid = "'.$fid.'" and id = "'.(int)$_GET['pid'].'" ';
		$edited = TRUE;
	}

}
	$name = $_POST['title'];
	$mag_desc = $_POST['description'];
	$mag_price = $_POST['price'];
	$category  = $_POST['category'];
	$pictures  = explode(",",$_POST['pictures']);
	$pic1 = $pictures[0];
	$tags = $_POST['tags'];
	// if(!preg_match('/^[a-z\W\d\-\_\$]+$/is',$_POST['title']))
	// {
	// 	$msg[]='Please provide a valid name of the event';
	// }
	if(!trim($_POST['title']))
	{
		$msg[]='Please provide a valid name of the event';
	}
	if(strlen($_POST['description'])<50)
	{
		$msg[]='Please provide a detailed description of the event, not less the 50 characters';
	}
	if(!trim($_POST['address']))
	{
		$msg[]='Please provide a valid address for the event';
	}
	if(!trim($_POST['city']))
	{
		$msg[]='Please provide a valid city for the event';
	}
	if(!(int)$_POST['price']&&(int)$_POST['price']<100)
	{
		$msg[]='Please specify a valid price, minimum of 100';
	}
	if(!trim($_POST['tags']))
	{
		$msg[]='Please provide at least one tag, tags are important to make your events easier to discover';
	}
	else
	{
		$tags = explode(",",$_POST['tags']);
		foreach($tags as $ts)
		{
			$checkTag = $con->prepare("select 1 from tags where name = :name");
			$checkTag->execute(array(':name'=>trim(strtolower($ts))));
			if($checkTag->fetch())
			{
				$nTags[]=strtolower(trim($ts));
			}
		}
		if(!count($nTags))
		{
			$msg[]='Please provide an existing tag, tags are important to make your events easier to discover';
		}
		$picUpload = new PicUpload('image_file',200,(2*1024*1024),1500,'thumb_','i_images/',90,500,500);
		// __construct($file_name,$file_size=1024,$destination_folder)
		$picx = $picx?$picx:$c_pix;
}
	if(!count($msg))
	{
		$title = trim($_POST['title']);
		$body = trim(strip_tags($_POST['description'],'<img><b><i><u><h1><h2><h3><h4><h5><h6><br><p><ul><li><ol><dl>'));
		$price = (int)$_POST['price'];
		$category = trim($_POST['category']);
		$tags = implode(",",$nTags);
		// die("$title $body $draft $goal $tags $url $hasdonate");
		$submit = $con->prepare("$u_str set title=?, description=?, pictures=?, price =?, category = ?, iid=?, tags=?,date='".date("Y-m-d H:i:s")."' $u_wh ");
		if($submit->execute(array($title, $body, $picx, $price, $category, $fid,$tags)))
		{
			$psid = $con->lastInsertId();
			header("Location:{$web}/events/$psid");
			exit;
		}
		else
		{
			$msg[]='Sorry, error processing your request, event not saved.';
		}
	}
}
?>