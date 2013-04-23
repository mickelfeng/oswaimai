<?php
@session_start();
include "../global.php";
if (empty($_SESSION['uname'])){
	header("location:login.php");exit();
}
$dinid=$_GET['dinid'];
$query="delete from wm_dininfo where dinid='".$dinid."'";
if($db->query($query))
{
	echo "<script language='javascript'>history.go(-1);</script>";
}
?>
