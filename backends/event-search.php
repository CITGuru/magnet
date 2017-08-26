<?php
require 'incs/index.php';
$str = $_GET['event'];
$results = getDBString('events',["*"]," where name like '%$str%' or location like '%$str%' or purpose like '%$str%' order by id desc");
?>