<?php
include_once('./global.php');
include "./header.php";
$sqlforums = "select * from wm_bbs_forums where forum_parent=0";
$result =$db->query($sqlforums)->fetchall();
foreach($result as $res)
{
	$resultall[$res['forum_id']]  = $db->query("select * from wm_bbs_forums where forum_parent='".$res['forum_id']."'")->fetchall();	
}
$smarty->assign("row",$result);	
$smarty->assign("resultall",$resultall);	
$smarty->display("bbs.tpl");
include "./footer.php";
?>