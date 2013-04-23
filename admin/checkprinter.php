<?php
header('Content-Type:text/html;charset=gb2312');
include "../global.php";

$sql="SELECT * FROM `wm_shopinfo` where printid='".$_POST['pid']."'";
$print = $db->query($sql)->fetchall();
if($print)
{
	echo "1";
}else
{
	echo "0";
}
?>