<?php
@session_start();
include "../global.php";
if(!$_SESSION['uname'])
{
	header("location:./index.php");exit();
}
$unex=explode('|',$_SESSION['uname']);
$sid=$unex[0];
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$query = "update `wm_shopinfo`  set yhcontent='$_POST[yhc]',yhdate='$_POST[time]',post_time=now()  where shopid='".$sid."'";
	$result = $db->query($query);
	if($result){
		echo "<IMG height=13 src=\"images/tick.png\" width=16 align=absMiddle /><font color='#FF0000'>修改成功</font>";
	}else{
		echo "<font color='#FF0000'>信息填写不完整请重新再试，谢谢！</font>";
	}
}
$row=get_yhinfo($db,$sid);
?>
<html>
<head>
<link rel="stylesheet" href="./css/main.css" type="text/css" />
<script type="text/javascript" src="../jcart/jquery-1.5.1.js"></script>
<script src="./js/ui/jquery.ui.core.js"></script>
<script src="./js/ui/jquery.ui.widget.js"></script>
<script src="./js/ui/jquery.ui.datepicker.js"></script>
<link href="./js/ui/jquery.ui.all.css" rel="stylesheet"  />
<script>
	$(function() {
		var dates = $( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 2,
			onSelect: function( selectedDate ) {
				$(this).datepicker( "option", "dateFormat", "yy-mm-dd");
			}
		});
	});
</script>
</head>
<body>
  <table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=3 style="height: 23px">优惠信息|修改</th>
      </tr>
	   <tr bgcolor="#DEE5FA">
        <td colspan="3" align="center" class=txlrow><font color="#FF0000"><strong>&nbsp;</strong></font></td>
      </tr>
      <tr bgcolor="#799AE1">
        <td width="50%" class=txlHeaderBackgroundAlternate>优惠内容</td>
        <td width="30%" class=txlHeaderBackgroundAlternate>优惠截止时间</td>
		<td width="20%" class=txlHeaderBackgroundAlternate>操作</td>
      </tr><?php
	  if($_GET['id']==$sid){
			echo "<form action=\"yhinfo.php\" method=\"post\">";
			echo "<tr>";
			echo "<td class=txlrow><textarea name=\"yhc\" cols=\"100\" rows=\"6\">".$row['yhcontent']."</textarea></td>";  
			echo "<td class=txlrow><input  onkeyup=\"this.value=''\" name=time id='to' value='".$row['yhtime']."'/></td>";  
			echo "<td class=txlrow><input type=submit value='保存'/></td>";  
			echo "</tr>";
			echo "</form>";	 
	  }else{
			echo "<tr>";
			echo "<td class=txlrow>".$row['yhcontent']."</td>";  
			echo "<td class=txlrow>".$row['yhdate']."</td>";  
			echo "<td class=txlrow><a href='yhinfo.php?id=".$sid."'>修改</a></td>";  
			echo "</tr>";
		}
	?>
</tbody>
</table>
</body>
</html>