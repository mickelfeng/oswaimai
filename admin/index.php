<?php 
session_start();
include "../global.php";
if($_SERVER['REQUEST_METHOD']=='POST'){
$username = $_POST['username'];
$password = $_POST['password'];
$sql="select username,shopid from wm_admin_b where username='".$username."' and password = sha1('".$password."')";
$res=$db->query($sql)->fetch();
if($res)
{
	$_SESSION['uname'] = $res['shopid']."|".$username;
	header("location:default.php");exit();
	
}else{
	echo "登录失败";
}
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
</head>
<body style="margin:0px; padding:0px">
<div style="height:100px; width:300px; margin:200px auto; border:1px solid #e7e7e7">
<form action="" method="post">
<table border="0" width="100%">
<tr><td align="right">用户名称：</td><td><input type="text" name="username" value="" id="username" style="width:140px"/></td></tr>
<tr><td align="right">用户密码：</td><td><input type="password" name="password" value="" id="password" style="width:140px"/></td></tr>
<tr><td></td><td><input type="submit" value="登录" /></td></tr>
</table>
</form>
</div>
</body>
</html>
