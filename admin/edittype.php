<?php
@session_start();
include "../global.php";

if (empty($_SESSION['uname'])){
	header("location:login.php");exit();
}
$unex=explode('|',$_SESSION['uname']);
$sid=$unex[0];

$typeid=empty($_GET['typeid'])?$_POST['typeid']:$_GET['typeid'];

if($_SERVER['REQUEST_METHOD']=='POST')
{           
           if($_POST['tname'])
		   {
			   $query = "update wm_dincategory set dintype='$_POST[tname]' where id='$typeid'";
			   $result = $db->query($query);
			   if($result){
				   echo "<font color='#FF0000'>修改成功</font> 1秒钟后自动返回<meta http-equiv='refresh' content=\"1; URL='addCategory.php'\" />";
			   }else{echo "修改失败";}
			}
			else
			{
				echo "<font color='#FF0000'>信息填写不完整请重新再试，谢谢！</font>";
			}
}
$shopid   = get_admin($db,$sid);
$typename = get_dintypename($db,$sid,$typeid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" href="./css/main.css" type="text/css" />
<title>无标题文档</title>
</head>
<body>
  <form action="edittype.php" method="post" >
  <table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=6 style="height: 23px">餐品类别修改</th>
      </tr>
	  <tr bgcolor="#DEE5FA">
        <td colspan="4" align="center" class=txlrow><font color="#FF0000">注意：类别编号关联餐品信息的餐品类型，请谨慎操作，谢谢！</font></td>
      </tr>
      <tr align="center" bgcolor="#799AE1">
        <td width="35%" align="center" class=txlHeaderBackgroundAlternate>类别编号</td>
        <td width="35%"  align="center" class=txlHeaderBackgroundAlternate>类别名称</td>
        <td colspan="2"  align="center" class=txlHeaderBackgroundAlternate>操作</td>
      </tr>  
	   <tr>
        <td width="35%" align="center"  class=txlrow><input type="hidden" name="typeid" value="<?php echo $typeid;?>" /><?php echo $typeid;?></td>
        <td width="35%"  align="center" class=txlrow><input type="text" name="tname" size="20" value="<?php echo $typename;?>" /></td>
        <td colspan="2"  align="center" class=txlrow><input type="submit" value="保存" /></td>
      </tr>  
	</tbody>
  </table>
  </form>
</body>
</html>