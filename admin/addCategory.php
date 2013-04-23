<?php
@session_start();
include "../global.php";
if (empty($_SESSION['uname'])){
	header("location:./index.php");exit();
}
$unex=explode('|',$_SESSION['uname']);
$sid=$unex[0];
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(empty($_POST['tid'])){
		$isql="insert into `wm_dincategory`(`shopid`,`dintype`) values('$sid','$_POST[typename]')";
		if($db->query($isql)){
			echo "<font color='#FF0000'>添加成功</font>";
		}
	}else{
		$usql="update `wm_dincategory` set `dintype`='$_POST[typename]' where `id`='$_POST[tid]' and `shopid`='$sid'";
		if($db->query($usql)){
			echo "<font color='#FF0000'>添加成功</font>";
		}else{
			echo "<font color='red'>添加失败</font>";
		}
	}
}
if(isset($_GET['did']))
{
	$ssql ="SELECT `dinid` FROM `wm_dininfo` where `shopid`='$sid' and `dintype`='$_GET[did]' limit 0,1";
	$ts = $db->query($ssql)->fetch();
	if(empty($ts)){
	    $dsql="delete from `wm_dincategory` where `shopid`='$sid' and `id`='$_GET[did]'";
		if($db->query($dsql)){
			echo "<font color='red'>删除成功</font>";
		}else{
			echo "<font color='red'>删除失败</font>";
		}
	}else{
		echo "<font color='red'>此类型已关联，无法进行删除</font>";
	}
}
$arr=getcategory($db,$sid,0);
?>
<html>
<head>
<link rel="stylesheet" href="./css/main.css" type="text/css" />
</head>
<body>
  <table  width="30%" border=0 cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=4 style="height: 23px">餐品类别|添加</th>
      </tr>
      <tr align="center" bgcolor="#799AE1">
        <td width="35%"  align="center" class=txlHeaderBackgroundAlternate>类别名称</td>
        <td colspan="2"  align="center" class=txlHeaderBackgroundAlternate>操作</td>
      </tr>  
	  <?php if($arr){foreach($arr as $row){
		  if($_GET['id']==$row['id']){
			  echo "<tr><form style='padding:0px; margin:0px;' action='addCategory.php' method='post'>";
			  echo "<td align=center class=txlrow><input type='hidden' name='tid' value='".$row['id']."'><input type='text' name='typename' id='typename' value='".$row['dintype']."'/></td>";
			  echo "<td align=center class=txlrow><input type='submit' value='确认修改' /></td>";
			  echo "</form></tr>";
		  }else{
			  echo "<tr>";
			  echo "<td align=center class=txlrow>".$row['dintype']."</td>";
			  echo "<td align=center class=txlrow>"."<a href=?id=".$row['id'].">编辑</a>&nbsp;<a href='?did=".$row['id']."'>删除</a></td>";
		  }}}?>
      <tr>
      <form style="padding:0px; margin:0px;" action="addCategory.php" method="post">
      <td align=center class=txlrow><input type="text" name="typename" id="typename" /></td>
      <td align=center class=txlrow><input type="submit" value="添加" /></td>
      </form>
      </tr>
	</tbody>
  </table>

</body>
</html>