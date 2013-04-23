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
	$pid     = $_POST['pid'];
	$printid = $_POST['printer_id'];
	
	$selectsql="select `id` from `wm_printer` where `printer_id`='".$printid."'";
	$cz=$db->query($selectsql)->fetchall();
	if(!empty($cz)){
		echo "<font color='red'>您添加的打印机已经存在！</font>";
	}else
	{
		if(!empty($pid)){
			$query="update `wm_printer` set `printer_id`='".$printid."' where id='".$pid."'";
		}else{
			$query="insert into `wm_printer` values('','".$printid."')";
		}
		$db->query($query);
	}
}
if(!empty($_GET['del']))
{
	$delsql="delete from `wm_printer` where `id`='".$_GET['del']."'";
	if(!$db->query($delsql)){
		echo "<font color='red'>删除失败</font>";
	}else{
		echo "<font color='red'>删除成功</font>";
	}
}
$sql="SELECT * FROM `wm_printer`";
$printers = $db->query($sql)->fetchall();
?>
<table  width="40%" border=0 cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=2 style="height: 23px">打印机管理</th>
      </tr>
	   <tr bgcolor="#DEE5FA">
        <td align="center" colspan="2" align="center" class=txlrow><font color="#FF0000"><strong>&nbsp;</strong></font></td>
      </tr>
      <tr bgcolor="#799AE1">
        <td width="20%" class=txlHeaderBackgroundAlternate>打印机编号</td>
        <td width="20%" class=txlHeaderBackgroundAlternate>操作</td>
      </tr>
      <?php
	  foreach($printers as $mem)
	  {?>
      <tr>
      <?php if($_GET['edit']==$mem['id']){?>
      <form action="./printer.php" method="post">
      <td class=txlrow>
      <input type="hidden" value="<?php echo $mem['id']?>" name="pid" />
      <input type="text" value="<?php echo $mem['printer_id'];?>" name="printer_id" />
      </td>
      <td class=txlrow><input type="submit" value="保存" /></td>
      </form>
	  <?php }else{?>
      <td class=txlrow><?php echo $mem['printer_id'];?></td>
      <td class=txlrow><a href='?edit=<?php echo $mem['id']?>' onclick="return check_printer('<?php echo $mem['printer_id'];?>')">编辑</a>&nbsp;<a href="?del=<?php echo $mem['id'];?>" onclick="return check_printer('<?php echo $mem['printer_id'];?>')">删除</a></td>
      <?php }?>
      </tr>  
	  <?php
      }
	  ?>
      <tr>
      <form action="./printer.php" method="post">
      <td class="txlRow"><input type="text" name="printer_id" value="" /></td>
      <td class="txlRow"><input type="submit" value="添加" /></td>
      </form>
      </tr>
</tbody>
</table>
<script type="text/javascript" language="javascript">
function check_printer(pid)
{	
	var exist = false;
		$.ajax({type: "POST",dataType : "text",async : false,url: "./checkprinter.php",
			data: {"pid" : pid},
			success: function(res){if(res == 1) {alert("打印机已关联，此操作无法进行！");exist = false;}else if(res == 0) {exist = true;}},
			error : function(res,msg,err) {alert(msg);}
		});
	return exist;
		
}
</script>