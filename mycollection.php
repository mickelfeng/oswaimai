<?php
session_start();
if(!isset($_SESSION['email']))
{
	header("Location:./index.php");
}
include_once('./global.php');
include "./header.php";
$sql="SELECT `wm_saveshop` . `shopid`, `wm_saveshop`.`savetime`, `wm_shopinfo`.`shopname`
FROM `wm_saveshop`
RIGHT OUTER JOIN `wm_shopinfo` ON `wm_saveshop`.`shopid` = `wm_shopinfo`.`shopid`
WHERE `wm_saveshop`.`username` = '$_SESSION[email]'
ORDER BY `wm_saveshop`.`savetime` ASC ";
$collections = $db->query($sql)->fetchall();
$smarty->assign("collections",$collections);
$smarty->display("mycollection.tpl");
include "./footer.php";
?>