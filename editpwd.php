<?php
session_start();
if(!isset($_SESSION['email']))
{
	header("Location:./index.php");
}
include_once('./global.php');
include "./header.php";
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if($_POST['newpwd']!=$_POST['rpwd'])
	{
		header("Location:./editpwd.php?error=pwd");exit;	
	}
	
	$sql="update wm_admin_c set password='".md5($_POST['newpwd'].'welwm')."' where email='".$_SESSION['email']."'";
    $count = $db->query($sql)->rowCount();
	if($count==1)
	{
		$smarty->assign('tag',"ÃÜÂëÐÞ¸Ä³É¹¦");
	}
}
$smarty->display("editpwd.tpl");
include "./footer.php";
?>