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
	$sql="update wm_admin_c set email='".$_POST['newemail']."' where email='".$_SESSION['email']."'";
    $count = $db->query($sql)->rowCount();
	if($count==1)
	{
		$smarty->assign('tag',"密码修改成功");
	}	
}
$smarty->assign('email',$_SESSION['email']);
$smarty->display("editemail.tpl");
include "./footer.php";
?>