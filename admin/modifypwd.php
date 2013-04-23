<?php
@session_start();
if(!$_SESSION['uname'])
{
	header("location:./index.php");exit();
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$unex=explode('|',$_SESSION['uname']);
	$sid=$unex[0];
	include "../global.php";
	extract($_POST);
	$res = $db->query("select * from wm_admin_b where shopid='".$sid."'and password='".sha1($oldpwd)."'")->fetch();
	if($res){
		if(strlen($newpwd)<6)
		{
			echo "<script>alert('密码长度不小于6位')</script>";	
		}elseif($newpwd!=$renewpwd){
			echo "<script>alert('两次密码输入不正确')</script>";	
		}else
		{
			$r=$db->query("update wm_admin_b set password='".sha1($newpwd)."' where shopid='".$sid."'");
			if($r){
				echo "<script>alert('修改成功')</script>";	
			}else{
				echo "<script>alert('修改失败')</script>";	
			}
		}
	}else{ 
	    echo "<script>alert('密码输入错误')</script>";
	}
}
?>
<html>
<head>
<link rel="stylesheet" href="./css/main.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
</head>
<body>
  <form action="" method="post">
  <table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=4 style="height: 23px">修改密码</th>
      </tr>
      <tr bgcolor="#DEE5FA">
        <td colspan="4" align="center" class=txlrow><font color="#FF0000"><strong>&nbsp;</strong></font></td>
      </tr>
      <tr align="center" bgcolor="#799AE1">
        <td width="20%"  align="center" class=txlHeaderBackgroundAlternate>原始密码</td>
        <td width="20%"  align="center" class=txlHeaderBackgroundAlternate>新密码</td>
        <td width="20%"  align="center" class=txlHeaderBackgroundAlternate>确认密码</td>
        <td width="20%"  align="center" class=txlHeaderBackgroundAlternate>操作</td>
      </tr>
      <tr>
      <td align=center class=txlrow><input type="password" name="oldpwd" id="oldpwd"  /></td>
      <td align=center class=txlrow><input type="password" name="newpwd" id="newpwd"  /></td>
      <td align=center class=txlrow><input type="password" name="renewpwd" id="renewpwd"  /></td>
      <td align=center class=txlrow><input type="submit" value="确定修改" /></td>
      </tr>
</tbody>
</table>
</form>
</body>
</html>