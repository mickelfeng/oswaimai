<?php
include_once('./global.php');
include "./header.php";
$smarty->display('aboutleft.tpl');
if($_SERVER['REQUEST_METHOD']=='POST')
{
    extract($_POST);
	if(empty($realname) ||empty($mobilephone)||empty($shopname))
	{
	echo "操作错误";exit;
	}
	echo "<div style='width:750px; min-height:400px; float:right'>";
	if($mark==$_SESSION['mark'])
	{
	    $sql="INSERT INTO `wm_shopinfo`(`contact`,`shoptel`,`shop_deskphone`,`shop_qq`,`shopname` ,`shopadd` ,`shopintro` ,`shoptype` )VALUES ('$realname','$mobilephone','$deskphone','$qq','$shopname','$shopaddress','$shopinfo',0)";
		$res=$db->query($sql);
		echo $res->rowCount()?"申请成功,我们将尽快与您联系！":"申请失败";
		unset($_SESSION['mark']);
	}else
	{
	echo "请不要重复刷新";
	}
	echo "</div>";
}
else{
$_SESSION['mark']=time();
$smarty->assign('mark',$_SESSION['mark']);
$smarty->display('kaidian.tpl');
}
include "./footer.php";
?>