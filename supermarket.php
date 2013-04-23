<?php
include_once('./global.php');
include 'jcart/jcart.php';
include "./header.php";
?>
<div id="content">
正在开发，敬请期待......
</div>
<?php
/*session_start();
$cart =& $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();
$contents=$cart->get_contents();

$tag=false;
foreach($contents as $row){
	if($row['shop']!=6){$tag=true;}
}
if(!empty($contents)&& $tag){
}

$fsql="SELECT * FROM `wm_dincategory` WHERE `shopid`=6 and `fid`=0 and `dintype`<>'NULL'";
$ftype=$db->query($fsql)->fetchAll();
foreach ($ftype as $row)
{
    $ssql="SELECT * FROM `wm_dincategory` WHERE `shopid`=6 and `fid`='".$row['id']."' and `dintype`<>'NULL'";
    $stype[$row['id']]=$db->query($ssql)->fetchAll();
}
$smarty->assign('ftype',$ftype);
$smarty->assign('stype',$stype);

$psql="SELECT * FROM `wm_dininfo` WHERE `shopid` =6 ";
$products=$db->query($psql)->fetchAll();

$smarty->assign('products',$products);
$smarty->display('supermarket.tpl');*/

include "./footer.php";
?>
