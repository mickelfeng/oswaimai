<?php
@session_start();
include "../global.php";
if(!$_SESSION['uname']){
	header("location:./index.php");exit();
}
$unex=explode('|',$_SESSION['uname']);
$sid=$unex[0];
if($_SERVER['REQUEST_METHOD']=='POST')
{
	extract($_POST);
	if(!empty($updateid))
	{
	}else
	{
		$db->query("insert into `wm_shoplinkbul` values('','$sid','$areaid','$min_price','$fee')");
	}
}
//删除配送区域
if(!empty($_GET['delete']))
{
	$db->query("delete from `wm_shoplinkbul` where `id`='".$_GET['delete']."'");
}

$bulids=$db->query("SELECT * FROM `wm_shoplinkbul` where `shopid`=$sid")->fetchall();
function get_areaname($db,$areaid)
{
	$sql="SELECT `areaname` FROM `wm_areainfo` where `id`=$areaid";
	return $db->query($sql)->fetchColumn();
}
function get_areaid($db,$shopid)
{
	$sql="SELECT `shoparea` FROM `wm_shopinfo` where `shopid`=$shopid";
	return $db->query($sql)->fetchColumn();
}

$areaid=get_areaid($db,$sid);
$areabul=$db->query("SELECT `id`,`areaname` FROM `wm_areainfo` WHERE `fid`='$areaid' and `id` not in(SELECT `areaid` FROM `wm_shoplinkbul` where `shopid`=$sid)")->fetchall();
?>
<html>
<head>
<link rel="stylesheet" href="./css/main.css" type="text/css" />
<script type="text/javascript">
	function clearNoNum(event,obj){ 
        event = window.event||event; 
        if(event.keyCode == 37 | event.keyCode == 39){ 
            return; 
        } 
        obj.value = obj.value.replace(/[^\d.]/g,""); 
        obj.value = obj.value.replace(/^\./g,""); 
        obj.value = obj.value.replace(/\.{2,}/g,"."); 
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$","."); 
    } 
    function checkNum(obj){ 
        obj.value = obj.value.replace(/\.$/g,"");
    }
</script>
</head>
<body>
  <table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=4 style="height: 23px">配送范围</th>
      </tr>
	   <tr bgcolor="#DEE5FA">
        <td align="center" colspan="4" align="center" class=txlrow><font color="#FF0000"><strong>&nbsp;</strong></font></td>
      </tr>
      <tr bgcolor="#799AE1">
        <td width="40%" class=txlHeaderBackgroundAlternate>配送区域</td>
        <td width="20%" class=txlHeaderBackgroundAlternate>送餐费</td>
        <td width="20%" class=txlHeaderBackgroundAlternate>起送价格</td>
		<td width="20%" class=txlHeaderBackgroundAlternate>操作</td>
      </tr>
	  <?php
	      if(!empty($bulids))
		  {
			  foreach($bulids as $row)
			  {
				  echo "<tr>";
				  echo "<td class=txlrow>".get_areaname($db,$row['areaid'])."</td>";  
				  echo "<td class=txlrow>".$row['fee']."元</td>";
				  echo "<td class=txlrow>".$row['min_price']."元</td>";
				  echo "<td class=txlrow><a href='?delete=".$row['id']."'>删除</a></td>";
				  echo "</tr>";
			  }
		  }
	?>
</tbody>
</table>
<form action="range.php" method="post">
<?php 
if(!empty($_GET['edit'])){
	echo "<input type='hidden' name='updateid' value='".$_GET['edit']."' />";	
}
?>
<table width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder style="margin-top:20px">
<tr><td width="10%" class=txlHeaderBackgroundAlternate>配送区域</td><td>
<select name="areaid">
<?php
foreach($areabul as $row)
{
	echo "<option value='".$row['id']."'>".$row['areaname']."</option>";	
}
?>
</select>
</td></tr>
<tr><td width="10%" class=txlHeaderBackgroundAlternate>送餐费</td><td>
<input type="text" name="fee" onBlur='checkNum(this)' onKeyUp='clearNoNum(event,this)' onselectstart='return false' onpaste='return false' />
</td></tr>
<tr><td width="10%" class=txlHeaderBackgroundAlternate>起送价格</td><td>
<input type="text" name="min_price" onBlur='checkNum(this)' onKeyUp='clearNoNum(event,this)' onselectstart='return false' onpaste='return false' />
</td></tr>
<tr><td width="10%" class=txlHeaderBackgroundAlternate></td><td><input type="submit" value="确定" /></td></tr>
</table>
</form>
</body>
</html>