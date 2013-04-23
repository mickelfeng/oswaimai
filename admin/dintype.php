<script type="text/javascript" src="../jcart/jquery-1.5.1.js"></script>
<link rel="stylesheet" href="./css/main.css" type="text/css" />
<?php
@session_start();
include "../global.php";
if(!$_SESSION['uname']){
	header("location:./index.php");exit();
}
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$tid      = $_POST['tid'];
	$typename = $_POST['typename'];
	if(empty($typename))
	{
		echo "<font color='#FF0000'>餐店类别不能为空</font>";
	}else
	{
		if(!empty($tid))
		{
			$query="update `wm_dintype` set `typename`='".$typename."' where id='".$tid."'";
		}else
		{
			$query="insert into `wm_dintype` values('','".$typename."')";	
		}
		$db->query($query);
	}
}
$del = $_GET['del'];
if(!empty($del))
{
	$delsql="delete from `wm_dintype` where `id`='".$del."'";
	if($db->query($delsql))
	{
		echo "<font color='#FF0000'>删除成功</font>";	
	}
}
$sql="SELECT * FROM `wm_dintype`";
$shoptype = $db->query($sql)->fetchall();
?>
<table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=2 style="height: 23px">餐店类别管理</th>
      </tr>
	   <tr bgcolor="#DEE5FA">
        <td align="center" colspan="2" align="center" class=txlrow><font color="#FF0000"><strong>&nbsp;</strong></font></td>
      </tr>
      <tr bgcolor="#799AE1">
        <td width="20%" class=txlHeaderBackgroundAlternate>餐店类别</td>
        <td width="20%" class=txlHeaderBackgroundAlternate>操作</td>
      </tr>
      <?php
	  foreach($shoptype as $mem)
	  {?>
      <tr>
      <?php if($_GET['edit']==$mem['id']){?>
      <form action="./dintype.php" method="post">
      <td class=txlrow>
      <input type="hidden" value="<?php echo $mem['id']?>" name="tid" />
      <input type="text" value="<?php echo $mem['typename'];?>" name="typename" />
      </td>
      <td class=txlrow><input type="submit" value="保存" /></td>
      </form>
	  <?php }else{?>
      <td class=txlrow><?php echo $mem['typename'];?></td>
      <td class=txlrow><a href='?edit=<?php echo $mem['id']?>')">编辑</a>&nbsp;<a href="?del=<?php echo $mem['id']?>">删除</a></td>
      <?php }?>
      </tr>  
	  <?php
      }
	  ?>
      <tr>
      <form action="./dintype.php" method="post">
      <td class="txlRow"><input type="text" name="typename" value="" /></td>
      <td class="txlRow"><input type="submit" value="添加" /></td>
      </form>
      </tr>
</tbody>
</table>