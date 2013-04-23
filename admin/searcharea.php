<?php
header('Content-Type:text/html;charset=gb2312');

include "../global.php";

$sql="SELECT `id`,`areaname` FROM `wm_areainfo` where fid='".$_GET['city']."'";
$area = $db->query($sql)->fetchall();
if(!empty($area))
{
	foreach($area as $row)
	{
		echo "<option value='".$row['id']."'>".$row['areaname']."</option>";
	}
}else
{
	echo "<option value='0'>".ÔÝÎÞÇëÌí¼Ó."</option>";	
}
?>