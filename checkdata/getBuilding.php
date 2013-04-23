<?php
header("Content-type: text/html; charset=gb2312"); 
include('../global.php');

$sql = "select * from wm_areainfo where fid=0";

$districts = $db->query($sql)->fetchAll();
//$letter = array('A','B','C','D','E','F','G','H','J','K','L','M','N','O','P','Q','R','S','T','W','X','Y','Z');
?>
<div style="width:100%; height:30px; border-bottom:1px solid #e7e7e7;">
<table width="100%" height="100%">
<tr>
<?php
foreach($districts as $row)
{
echo "<td align='center' width='70px'><a href=\"javascript:showbul('dis".$row['id']."','district')\" id='dis".$row['id']."' class='district'>".$row['areaname']."</a></td>";
}
?>
</tr>
</table>
</div>
<?php 
$buildsql = "select * from wm_areainfo where fid<>0";
$builds = $db->query($buildsql)->fetchAll();
foreach($builds as $row)
{
echo "<ul style='list-style:none;margin:10px 5px;padding:0px'><li style='float:left;margin:0px 10px' class='dis".$row['fid']." build'>";?>
<a href="index.php" onclick="return setCookie('bid','<?php echo $row['id']?>','365')"><?php echo $row['areaname'];?>
</a></li></ul>
<?php
}
?>


