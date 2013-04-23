<?php

// JCART v1.1
// http://conceptlogic.com/jcart/

// THIS FILE IS CALLED WHEN ANY BUTTON ON THE CHECKOUT PAGE (PAYPAL CHECKOUT, UPDATE, OR EMPTY) IS CLICKED
// WE CAN ONLY DEFINE ONE FORM ACTION, SO THIS FILE ALLOWS US TO FORK THE FORM SUBMISSION DEPENDING ON WHICH BUTTON WAS CLICKED
// ALSO ALLOWS US TO VERIFY PRICES BEFORE SUBMITTING TO PAYPAL

// INCLUDE JCART BEFORE SESSION START
include_once 'jcart.php';

// START SESSION
session_start();

// INITIALIZE JCART AFTER SESSION START
$cart =& $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();

// WHEN JAVASCRIPT IS DISABLED THE UPDATE AND EMPTY BUTTONS ARE DISPLAYED
// RE-DISPLAY THE CART IF THE VISITOR CLICKS EITHER BUTTON
if ($_POST['jcart_update_cart']  || $_POST['jcart_empty'])
	{

	// UPDATE THE CART
	if ($_POST['jcart_update_cart'])
		{
		$cart_updated = $cart->update_cart();
		if ($cart_updated !== true)
			{
			$_SESSION['quantity_error'] = true;
			}
		}

	// EMPTY THE CART
	if ($_POST['jcart_empty'])
		{
		$cart->empty_cart();
		}

	// REDIRECT BACK TO THE CHECKOUT PAGE
	header('Location: ' . $_POST['jcart_checkout_page']);
	exit;
	}

// THE VISITOR HAS CLICKED THE PAYPAL CHECKOUT BUTTON
else
	{

	///////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////
	/*

	A malicious visitor may try to change item prices before checking out,
	either via javascript or by posting from an external script.

	Here you can add PHP code that validates the submitted prices against
	your database or validates against hard-coded prices.

	The cart data has already been sanitized and is available thru the
	$cart->get_contents() function. For example:

	foreach ($cart->get_contents() as $item)
		{
		$item_id	= $item['id'];
		$item_name	= $item['name'];
		$item_price	= $item['price'];
		$item_qty	= $item['qty'];
		}

	*/
	///////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////

	$valid_prices = true;

	///////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////

	// IF THE SUBMITTED PRICES ARE NOT VALID
	if ($valid_prices !== true)
		{
		// KILL THE SCRIPT
		die($jcart['text']['checkout_error']);
		}

	// PRICE VALIDATION IS COMPLETE
	// SEND CART CONTENTS TO PAYPAL USING THEIR UPLOAD METHOD, FOR DETAILS SEE http://tinyurl.com/djoyoa
	else if ($valid_prices === true)
		{
		// PAYPAL COUNT STARTS AT ONE INSTEAD OF ZERO
		$paypal_count = 1;
		$items_query_string;
		foreach ($cart->get_contents() as $item)
			{
			// BUILD THE QUERY STRING
			$items_query_string .= '&item_name_' . $paypal_count . '=' . $item['name'];
			$items_query_string .= '&amount_' . $paypal_count . '=' . $item['price'];
			$items_query_string .= '&quantity_' . $paypal_count . '=' . $item['qty'];

			// INCREMENT THE COUNTER
			++$paypal_count;
			}

		// EMPTY THE CART
		$cart->empty_cart();

		if($jcart['paypal_id'])
			{
			// REDIRECT TO PAYPAL WITH MERCHANT ID AND CART CONTENTS
			header( 'Location: https://www.paypal.com/cgi-bin/webscr?cmd=_cart&upload=1&business=' . $jcart['paypal_id'] . $items_query_string);
			exit;
			}
		else
			// THE USER HAS NOT CONFIGURED A PAYPAL ID
			// DISPLAY THE PAYPAL URL WITH AN ERROR MESSAGE
			{
			echo 'PayPal integration requires a secure merchant ID. Please see the <a href="http://conceptlogic.com/jcart/install.php">installation instructions</a> for more info.<br /><br />';
			echo 'Below is the URL that would be sent to PayPal if a merchant ID was set in <strong>jcart-config.php</strong>:<br /><br />';
			echo 'https://www.paypal.com/cgi-bin/webscr?cmd=_cart&upload=1&business=PAYPAL_ID' . $items_query_string;
			exit;
			}
		}
	}

?>
