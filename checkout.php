<?php
include_once('./global.php');
include 'jcart/jcart.php';
include "./header.php";
echo "<div id='content'>";
session_start();
$cart =& $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();
isset($_COOKIE['bid'])?$bulid=$_COOKIE['bid']:header("location:./index.php");
//$area  = get_area($db,$bulid);
//$smarty->assign("buildname",$area['b']);
$smarty->assign("shopcart",$cart->display_cart($jcart));
$sctime=get_sctime();
$smarty->assign('sctime',$sctime);
if(isset($_SESSION['email']))
{
	$scadd=get_scadd($db,$_SESSION['email']);
	$smarty->assign('scadd',$scadd);
}
$smarty->display("checkout.tpl");
 include "./footer.php";
?>

