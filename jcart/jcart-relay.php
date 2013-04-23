<?php

// JCART v1.1
// http://conceptlogic.com/jcart/

// THIS FILE TAKES INPUT FROM AJAX REQUESTS VIA JQUERY post AND get METHODS, THEN PASSES DATA TO JCART
// RETURNS UPDATED CART HTML BACK TO SUBMITTING PAGE

// INCLUDE JCART BEFORE SESSION START
include_once 'jcart.php';

// START SESSION
session_start();

// INITIALIZE JCART AFTER SESSION START
$cart =& $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();
if($_POST['empty']==1)
{
	$cart->empty_cart();
}
// PROCESS INPUT AND RETURN UPDATED CART HTML
$cart->display_cart($jcart);

?>
