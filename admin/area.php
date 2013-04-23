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
	$id = $_POST['id'];
	$fid = $_POST['fid'];
	$areaname = $_POST['areaname'];
	
	if(empty($areaname)){
		echo "<font color='red'>区域不能为空</font>";
	}else{
		if(!empty($id)){
			$sql="update `wm_areainfo` set `areaname`='".$areaname."' where id='".$id."'";
		}else{
			$sql="insert into `wm_areainfo`(`areaname`,`fid`) values('".$areaname."','".$fid."')";
		}
		$db->query($sql);
	}
	
}
$sql="SELECT * FROM `wm_areainfo` where `fid`=0";
$cities = $db->query($sql)->fetchall();
foreach($cities as $row)
{
	$zonesql="select * from `wm_areainfo` where `fid`='".$row['id']."'";
	$zones[$row['id']]=$db->query($zonesql)->fetchall();
	foreach($zones[$row['id']] as $brow)
	{
		$bsql="select * from `wm_areainfo` where `fid`='".$brow['id']."'";	
		$bul[$brow['id']]=$db->query($bsql)->fetchall();
	}
}
?>
<table  width="400px" border=0 cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=2 style="height: 23px">区域管理</th>
      </tr>
	   <tr bgcolor="#DEE5FA">
        <td align="center" colspan="2" align="center" class=txlrow><font color="#FF0000"><strong>&nbsp;</strong></font></td>
      </tr>
      <tr bgcolor="#799AE1">
        <td width="200px" class=txlHeaderBackgroundAlternate>区域</td>
        <td width="200px" class=txlHeaderBackgroundAlternate>操作&nbsp;&nbsp;<a href="#" onclick="javascript:$('#addcity').show()">添加城市</a></td>
      </tr>
      <tr id="addcity" style="display:none">
      <form action="./area.php" method="post">
      <td class="txlRow"><input type="hidden" name="fid" value="0" /><input type="text" name="areaname" value="" /></td>
      <td class="txlRow"><input type="submit" value="添加" /></td>
      </form>
      </tr>
      <?php
	  foreach($cities as $mem)
	  {
		  echo "<tr>";
		  if($mem['id']==$_GET['edit']){?>
          <form action="./area.php" method="post">
      <td class=txlrow><input type="hidden" name="id" value="<?php echo $mem['id'];?>" />
      <input type="text" value="<?php echo $mem['areaname'];?>" name="areaname" /></td>
      <td class=txlrow><input type="submit" value="保存" /></td>
      </form>
      <?php }else{?>
      
      <td class=txlrow><?php echo $mem['areaname'];?></td>
      <td class=txlrow><a href='?edit=<?php echo $mem['id']?>')">编辑</a>&nbsp;&nbsp;<a href="#" onclick="javascript:$('#addzone<?php echo $mem['id']?>').show()">添加区域</a></td>
      
      <?php }?>
      </tr>
      <tr id="addzone<?php echo $mem['id']?>" style="display:none" align="center">
      <form action="./area.php" method="post">
      <td class="txlRow"><input type="hidden" name="fid" value="<?php echo $mem['id']?>" /><input type="text" name="areaname" value="" /></td>
      <td class="txlRow"><input type="submit" value="添加" /></td>
      </form>
      </tr>
      <?php 
	  foreach($zones[$mem['id']] as $row){
		  
           echo "<tr align='center'>";
            if($row['id']==$_GET['edit']){?>
          <form action="./area.php" method="post">
      <td class=txlrow><input type="hidden" name="id" value="<?php echo $row['id'];?>" />
      <input type="text" value="<?php echo $row['areaname'];?>" name="areaname" /></td>
      <td class=txlrow><input type="submit" value="保存" /></td>
      </form>
      <?php }else{?>
      
      <td class=txlrow><?php echo $row['areaname'];?></td>
      <td class=txlrow><a href='?edit=<?php echo $row['id']?>')">编辑</a>&nbsp;&nbsp;<a href="#" onclick="javascript:$('#addbul<?php echo $row['id']?>').show()">添加写字楼</a></td>
      
      <?php }?>
           </tr>
           <tr id="addbul<?php echo $row['id']?>" style="display:none" align="right">
      <form action="./area.php" method="post">
      <td class="txlRow"><input type="hidden" name="fid" value="<?php echo $row['id']?>" /><input type="text" name="areaname" value="" /></td>
      <td class="txlRow"><input type="submit" value="添加" /></td>
      </form>
      </tr>
          <?php
		  foreach($bul[$row['id']] as $bulrow)
		  {
			  echo "<tr align='right'>";
			  
           if($bulrow['id']==$_GET['edit']){?>
          <form action="./area.php" method="post">
      <td class=txlrow><input type="hidden" name="id" value="<?php echo $bulrow['id'];?>" />
      <input type="text" value="<?php echo $bulrow['areaname'];?>" name="areaname" /></td>
      <td class=txlrow><input type="submit" value="保存" /></td>
      </form>
      <?php }else{?>
      
      <td class=txlrow><?php echo $bulrow['areaname'];?></td>
      <td class=txlrow><a href='?edit=<?php echo $bulrow['id']?>')">编辑</a>&nbsp;&nbsp;</td>
      
      <?php }?>
           
           </tr>
          <?php
		  }
	  }
	 }
	  ?>
</tbody>
</table>