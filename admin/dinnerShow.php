<?php
@session_start();
include "../global.php";
if (empty($_SESSION['uname'])){
	header("location:login.php");exit();
}
$unex=explode('|',$_SESSION['uname']);
$sid=$unex[0];
$array=get_dininfo($db,$sid);
?>
<html>
<head>
<script type="text/javascript" language="javascript" src="script/calendar.js"></script>
<link rel="stylesheet" href="css/main.css" type="text/css" />
</head>
<body>
  <table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=7 style="height: 23px">餐品浏览与修改</th>
      </tr>
      <tr bgcolor="#DEE5FA">
        <td colspan="7" align="center" class=txlrow>&nbsp;</td>
      </tr>
      <tr align="center" bgcolor="#799AE1">
	    <td width="10%"  align="center" class=txlHeaderBackgroundAlternate>是否预售</td>
        <td width="20%"  align="center" class=txlHeaderBackgroundAlternate>餐品名称</td>
		<td width="20%"  align="center" class=txlHeaderBackgroundAlternate>餐品图片</td>
        <td width="20%"  align="center" class=txlHeaderBackgroundAlternate>餐品类型</td>
        <td width="20%"  align="center" class=txlHeaderBackgroundAlternate>餐品价格</td>
        <td  colspan="2"   align="center" class=txlHeaderBackgroundAlternate>操作</td>   
      </tr>  
<?php  
if($array){
foreach($array as $row)
{
echo "<tr>";
if($row['isellout']){$sell="<IMG height=13 src=\"images/tick.png\" width=16 align=absMiddle />";}else{$sell="<IMG height=13 src=\"images/cross.png\" width=16 align=absMiddle />";}
echo "<td align=center class=txlrow>".$sell."</td>";
echo "<td align=center class=txlrow>".$row['dinname']."</td>";  
?>

<td align=center class=txlrow>
<?php 
if($row['dinimage']){echo "<img src='".$row[dinimage]."' width='80px' hight='60px'/>";}else{  echo "&nbsp";}
?>
</td>
<?php 
echo "<td align=center class=txlrow>".get_dintypename($db,$row['shopid'],$row['dintype'])."</td>";
echo "<td align=center class=txlrow>".$row['dinprice']."</td>";
echo "<td align=center class=txlrow>"."<a href=delete.php?dinid=".$row['dinid'].">删除</a></td>";
echo "<td align=center class=txlrow>"."<a href=adddin.php?dinid=".$row['dinid'].">编辑</a></td>";
echo "</tr>";
 
}
}else{

}
?>
</tbody>
</table>
</body>
</html>
