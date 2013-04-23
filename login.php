<?php
include_once('./global.php');
session_start();
extract($_POST);
$query = strpos($username,"@")?"select * from wm_admin_c where email ='".$username."' and password = '".md5($password.'welwm')."'":"select * from wm_admin_c where nickname ='".$username."' and password = '".md5($password.'welwm')."'";
$user  = @$db->query($query)->fetch();
if($user)
{   if($remeber)
    {
	    setcookie("email",$user['email'],time()+3600*24*365);
	    setcookie("mark",md5($user['email'].$user['password']),time()+3600*24*365);
	}
    $_SESSION['email'] = $user['email'];
}else
{
    echo "密码或用户名错误，登陆失败<a href='index.php'>返回首页</a>";
	exit;
}
header("Location:./index.php");
?>