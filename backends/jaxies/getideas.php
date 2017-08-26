<?php
error_reporting(0);
require '../incs/index.php';
if(isset($_POST)&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=='xmlhttprequest')
{
	$getIdeas = $con->prepare("select id,title from ideas where draft='no' and iid=? order by id desc limit 50");
	$getIdeas->execute(array($fid));
	if($getIdeas->rowCount())
	{
		echo "<optgroup><option value='-1' selected='selected' onclick='loadThis(\"<i>Select an Idea</i>\",\"<i>Select an Idea</i>\");'>Select an Idea</option>";
	while($getIdeasRes=$getIdeas->fetch(PDO::FETCH_OBJ))
	{
		$iid = $getIdeasRes->id;
		$iname = $getIdeasRes->title;
		echo "<option value='$iid' onclick='loadThis(\"<a href=\\\"{$web}ideas/".(int)$iid."\\\" target=\\\"_blank\\\">".ucfirst($iname)."</a>\",\"".$web."ideas/".(int)$iid."\");'>".ucfirst($iname)."</option>";
	}
	echo "</optgroup>";
}
else
{
	die('noid!');
}
}
?>
