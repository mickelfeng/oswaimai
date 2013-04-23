<?php

// JCART v1.1
// http://conceptlogic.com/jcart/

// SESSION BASED SHOPPING CART CLASS FOR JCART

/**********************************************************************
Based on Webforce Cart v.1.5
(c) 2004-2005 Webforce Ltd, NZ
http://www.webforce.co.nz/cart/
**********************************************************************/
header('Content-Type:text/html;charset=gb2312');
// USER CONFIG
include_once('db_fns.php');
include_once('jcart-config.php');

// DEFAULT CONFIG VALUES
include_once('jcart-defaults.php');

// JCART
class jcart {
	var $total = 0;
	var $itemcount = 0;
	var $items = array();
	var $itemprices = array();
	var $itemqtys = array();
	var $itemname = array();
	var $itemshop = array();

	// CONSTRUCTOR FUNCTION

	function cart() {}

	// GET CART CONTENTS
	function get_contents()
		{
		$items = array();
		foreach($this->items as $tmp_item)
			{
			$item = FALSE;

			$item['id'] = $tmp_item;
			$item['qty'] = $this->itemqtys[$tmp_item];
			$item['price'] = $this->itemprices[$tmp_item];
			$item['name'] = $this->itemname[$tmp_item];
			$item['shop'] = $this->itemshop[$tmp_item];
			$item['subtotal'] = $item['qty'] * $item['price'];
			$items[] = $item;
			}
		return $items;
		}


	// ADD AN ITEM
	function add_item($item_id, $item_qty=1, $item_price, $item_name,$item_shop)
		{
		// VALIDATION
		$valid_item_qty = $valid_item_price = false;

		// IF THE ITEM QTY IS AN INTEGER, OR ZERO
		if (preg_match("/^[0-9-]+$/i", $item_qty))
			{
			$valid_item_qty = true;
			}
		// IF THE ITEM PRICE IS A FLOATING POINT NUMBER
		if (is_numeric($item_price))
			{
			$valid_item_price = true;
			}

		// ADD THE ITEM
		if ($valid_item_qty !== false && $valid_item_price !== false)
			{
			// IF THE ITEM IS ALREADY IN THE CART, INCREASE THE QTY
			if($this->itemqtys[$item_id] > 0)
				{
				$this->itemqtys[$item_id] = $item_qty + $this->itemqtys[$item_id];
				$this->_update_total();
				}
			// THIS IS A NEW ITEM
			else
				{
				$this->items[] = $item_id;
				$this->itemqtys[$item_id] = $item_qty;
				$this->itemprices[$item_id] = $item_price;
				$this->itemname[$item_id] = $item_name;
				$this->itemshop[$item_id] = $item_shop;
				}
			$this->_update_total();
			return true;
			}

		else if	($valid_item_qty !== true)
			{
			$error_type = 'qty';
			return $error_type;
			}
		else if	($valid_item_price !== true)
			{
			$error_type = 'price';
			return $error_type;
			}
		}

    
	// UPDATE AN ITEM
	function update_item($item_id, $item_qty)
		{
		// IF THE ITEM QTY IS AN INTEGER, OR ZERO
		// UPDATE THE ITEM
		if (preg_match("/^[0-9-]+$/i", $item_qty))
			{
			if($item_qty < 1)
				{
				$this->del_item($item_id);
				}
			else
				{
				$this->itemqtys[$item_id] = $item_qty;
				}
			$this->_update_total();
			return true;
			}
		}


	// UPDATE THE ENTIRE CART
	// VISITOR MAY CHANGE MULTIPLE FIELDS BEFORE CLICKING UPDATE
	// ONLY USED WHEN JAVASCRIPT IS DISABLED
	// WHEN JAVASCRIPT IS ENABLED, THE CART IS UPDATED ONKEYUP
	function update_cart()
		{
		// POST VALUE IS AN ARRAY OF ALL ITEM IDs IN THE CART
		if (is_array($_POST['jcart_item_ids']))
			{
			// TREAT VALUES AS A STRING FOR VALIDATION
			$item_ids = implode($_POST['jcart_item_ids']);
			}

		// POST VALUE IS AN ARRAY OF ALL ITEM QUANTITIES IN THE CART
		if (is_array($_POST['jcart_item_qty']))
			{
			// TREAT VALUES AS A STRING FOR VALIDATION
			$item_qtys = implode($_POST['jcart_item_qty']);
			}

		// IF NO ITEM IDs, THE CART IS EMPTY
		if ($_POST['jcart_item_id'])
			{
			// IF THE ITEM QTY IS AN INTEGER, OR ZERO, OR EMPTY
			// UPDATE THE ITEM
			if (preg_match("/^[0-9-]+$/i", $item_qtys) || $item_qtys == '')
				{
				// THE INDEX OF THE ITEM AND ITS QUANTITY IN THEIR RESPECTIVE ARRAYS
				$count = 0;

				// FOR EACH ITEM IN THE CART
				foreach ($_POST['jcart_item_id'] as $item_id)
					{
					// GET THE ITEM QTY AND DOUBLE-CHECK THAT THE VALUE IS AN INTEGER
					$update_item_qty = intval($_POST['jcart_item_qty'][$count]);

					if($update_item_qty < 1)
						{
						$this->del_item($item_id);
						}
					else
						{
						// UPDATE THE ITEM
						$this->update_item($item_id, $update_item_qty);
						}

					// INCREMENT INDEX FOR THE NEXT ITEM
					$count++;
					}
				return true;
				}
			}
		// IF NO ITEMS IN THE CART, RETURN TRUE TO PREVENT UNNECSSARY ERROR MESSAGE
		else if (!$_POST['jcart_item_id'])
			{
			return true;
			}
		}


	// REMOVE AN ITEM
	/*
	GET VAR COMES FROM A LINK, WITH THE ITEM ID TO BE REMOVED IN ITS QUERY STRING
	AFTER AN ITEM IS REMOVED ITS ID STAYS SET IN THE QUERY STRING, PREVENTING THE SAME ITEM FROM BEING ADDED BACK TO THE CART
	SO WE CHECK TO MAKE SURE ONLY THE GET VAR IS SET, AND NOT THE POST VARS

	USING POST VARS TO REMOVE ITEMS DOESN'T WORK BECAUSE WE HAVE TO PASS THE ID OF THE ITEM TO BE REMOVED AS THE VALUE OF THE BUTTON
	IF USING AN INPUT WITH TYPE SUBMIT, ALL BROWSERS DISPLAY THE ITEM ID, INSTEAD OF ALLOWING FOR USER FRIENDLY TEXT SUCH AS 'remove'
	IF USING AN INPUT WITH TYPE IMAGE, INTERNET EXPLORER DOES NOT SUBMIT THE VALUE, ONLY X AND Y COORDINATES WHERE BUTTON WAS CLICKED
	CAN'T USE A HIDDEN INPUT EITHER SINCE THE CART FORM HAS TO ENCOMPASS ALL ITEMS TO RECALCULATE TOTAL WHEN A QUANTITY IS CHANGED, WHICH MEANS THERE ARE MULTIPLE REMOVE BUTTONS AND NO WAY TO ASSOCIATE THEM WITH THE CORRECT HIDDEN INPUT
	*/
	function del_item($item_id)
		{
		$ti = array();
		$this->itemqtys[$item_id] = 0;
		foreach($this->items as $item)
			{
			if($item != $item_id)
				{
				$ti[] = $item;
				}
			}
		$this->items = $ti;
		$this->_update_total();
		}


	// EMPTY THE CART
	function empty_cart()
		{
		$this->total = 0;
		$this->itemcount = 0;
		$this->items = array();
		$this->itemprices = array();
		$this->itemqtys = array();
		$this->itemname = array();
		$this->itemshop = array();
		}


	// INTERNAL FUNCTION TO RECALCULATE TOTAL
	function _update_total()
		{
		$this->itemcount = 0;
		$this->total = 0;
		if(sizeof($this->items > 0))
			{
			foreach($this->items as $item)
				{
				$this->total = $this->total + ($this->itemprices[$item] * $this->itemqtys[$item]);

				// TOTAL ITEMS IN CART (ORIGINAL wfCart COUNTED TOTAL NUMBER OF LINE ITEMS)
				$this->itemcount += $this->itemqtys[$item];
				}
			}
		}
    

	// PROCESS AND DISPLAY CART
	function display_cart($jcart)
		{
		// JCART ARRAY HOLDS USER CONFIG SETTINGS
		extract($jcart);
       // Returns true if $string is valid UTF-8 and false otherwise. 
        function is_utf8($word) 
		{ 
			return preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true?true:false;
		} 
		// function is_utf8 
		function get_shop($id) {
       // query database for the name for a  bulid
          $conn = db_connect();
          $query = "select `shopname`,`linktime`,`shoptel` from wm_shopinfo where shopid = '".$id."'";
          $result = @$conn->query($query);
          $row = $result->fetch_object();
          return $row;
         }
		 
		 function get_minprice($sid)
		 {
		     $bulid  = isset($_COOKIE['bid'])?$_COOKIE['bid']:8;
		     $conn   = db_connect();
             $query  = "select `min_price` from  `wm_shoplinkbul` where shopid = '".$sid."' and areaid='".$bulid."'";
             $result = @$conn->query($query);
             $row    = $result->fetch_object();
             return $row;
		 }
		// ASSIGN USER CONFIG VALUES AS POST VAR LITERAL INDICES
		// INDICES ARE THE HTML NAME ATTRIBUTES FROM THE USERS ADD-TO-CART FORM
		$item_id    = $_POST[$item_id];
		$item_qty   = $_POST[$item_qty];
		$item_price = $_POST[$item_price];
		$item_name  = is_utf8($_POST[$item_name])?mb_convert_encoding($_POST[$item_name],'gb2312','utf-8'):$_POST[$item_name];
		$item_shop  = $_POST[$item_shop];

		// ADD AN ITEM
		if ($_POST[$item_add])
			{
			$item_added = $this->add_item($item_id, $item_qty, $item_price, $item_name,$item_shop);
			// IF NOT TRUE THE ADD ITEM FUNCTION RETURNS THE ERROR TYPE
			if ($item_added !== true)
				{
				$error_type = $item_added;
				switch($error_type)
					{
					case 'qty':
						$error_message = $text['quantity_error'];
						break;
					case 'price':
						$error_message = $text['price_error'];
						break;
					}
				}
			}

		// UPDATE A SINGLE ITEM
		// CHECKING POST VALUE AGAINST $text ARRAY FAILS?? HAVE TO CHECK AGAINST $jcart ARRAY
		if ($_POST['jcart_update_item'] == $jcart['text']['update_button'])
			{
			$item_updated = $this->update_item($_POST['item_id'], $_POST['item_qty']);
			if ($item_updated !== true)
				{
				$error_message = $text['quantity_error'];
				}
			}

		// UPDATE ALL ITEMS IN THE CART
	    	if($_POST['jcart_update_cart'] || $_POST['jcart_checkout'])
			{
			$cart_updated = $this->update_cart();
			if ($cart_updated !== true)
				{
				$error_message = $text['quantity_error'];
				}
			}

		// REMOVE AN ITEM
		if($_GET['jcart_remove'] && !$_POST[$item_add] && !$_POST['jcart_update_cart'] && !$_POST['jcart_check_out'])
			{
			$this->del_item($_GET['jcart_remove']);
			}

		// EMPTY THE CART
		if($_POST['jcart_empty'])
			{
			$this->empty_cart();
			}

		// DETERMINE WHICH TEXT TO USE FOR THE NUMBER OF ITEMS IN THE CART
	    	if ($this->itemcount >= 0)
			{
			$text['items_in_cart'] = $text['multiple_items'];
			}
		if ($this->itemcount == 1)
			{
			$text['items_in_cart'] = $text['single_item'];
			}

		// DETERMINE IF THIS IS THE CHECKOUT PAGE
		// WE FIRST CHECK THE REQUEST URI AGAINST THE USER CONFIG CHECKOUT (SET WHEN THE VISITOR FIRST CLICKS CHECKOUT)
		// WE ALSO CHECK FOR THE REQUEST VAR SENT FROM HIDDEN INPUT SENT BY AJAX REQUEST (SET WHEN VISITOR HAS JAVASCRIPT ENABLED AND UPDATES AN ITEM QTY)
		$is_checkout = strpos($_SERVER['REQUEST_URI'], $form_action);
		if ($is_checkout !== false || $_REQUEST['jcart_is_checkout'] == 'true')
			{
			$is_checkout = true;
			}
		else
			{
			$is_checkout = false;
			}

		// OVERWRITE THE CONFIG FORM ACTION TO POST TO jcart-gateway.php INSTEAD OF POSTING BACK TO CHECKOUT PAGE
		// THIS ALSO ALLOWS US TO VALIDATE PRICES BEFORE SENDING CART CONTENTS TO PAYPAL
		if ($is_checkout == true)
			{
			$form_action = $path . 'jcart-gateway.php';
			}

		// DEFAULT INPUT TYPE
		// CAN BE OVERRIDDEN IF USER SETS PATHS FOR BUTTON IMAGES
		$input_type = 'submit';

		// IF THIS ERROR IS TRUE THE VISITOR UPDATED THE CART FROM THE CHECKOUT PAGE USING AN INVALID PRICE FORMAT
		// PASSED AS A SESSION VAR SINCE THE CHECKOUT PAGE USES A HEADER REDIRECT
		// IF PASSED VIA GET THE QUERY STRING STAYS SET EVEN AFTER SUBSEQUENT POST REQUESTS
		if ($_SESSION['quantity_error'] == true)
			{
			$error_message = $text['quantity_error'];
			unset($_SESSION['quantity_error']);
			}

		// OUTPUT THE CART

		// IF THERE'S AN ERROR MESSAGE WRAP IT IN SOME HTML
		if ($error_message)
		{
		    $error_message = "<p class='jcart-error'>$error_message</p>";
		}

		// DISPLAY THE CART HEADER]
		echo "<div id='sidebar'>";
		echo "<!-- BEGIN JCART -->\n<div id='jcart'>\n";
		echo "\t$error_message\n";
		echo "\t<form method='post' action='$form_action'  onsubmit='return checkForm()' name='mycart'>\n";
		
		echo "\t\t<fieldset>\n";
		echo "\t\t\t<table border='1'>\n";
		echo "\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t<th id='jcart-header' colspan='3'>\n";
		echo "\t\t\t\t\t\t<span id='jcart-title'>" . $text['cart_title'] . "</span> (" . $this->itemcount . "&nbsp;" . $text['items_in_cart'] .")\n";
		echo "\t\t\t\t\t</th>\n";
		echo "\t\t\t\t</tr>". "\n";

		// IF ANY ITEMS IN THE CART
		if($this->itemcount > 0)
			{

			// DISPLAY LINE ITEMS
			
			  foreach($data=$this->get_contents() as $i=>$item)
			 {
			     $key[$i]=$item['shop'];
			  }
			  array_multisort($key,SORT_ASC,$data);	
			   foreach($data as $i=>$item)
			  {
			  $array[]=array($item['shop']=>$item['subtotal']);
			  $k[$item['shop']]=1;
			  }
			  $a=array_keys($k);
              foreach($a as $i)
			  {
			      $$i=0;
							  
			      foreach($array as $it)
			      {      
			         $$i+=$it[$i];
			      }
			  
			  }
			  foreach($a as $i)
			  {   
			     $p=get_minprice($item['shop'])->min_price;
			     echo   "<input type='hidden' name='s".$i."' value='".$$i."'/>";
			     $string.="document.mycart.s".$i.".value<$p||";
			  }
			    $len = strlen($string)-2;
                $string=substr($string, 0, $len); 
		       echo "<script>function checkForm(){if(".$string."){alert('您订的东西可能未满某一餐厅的起送价，请再检查一下？:-)');return false;}else{return true;}}</script>";
			 foreach($data as $item)
		     {
			    $now = strtotime(date("YmdHis"));	
				if($item['shop']!=$shop)
				{
					echo "<tr>";
					echo "<th colspan='1'>";
					echo  get_shop($item['shop'])->shopname;
					echo "</th>";
					echo "<th>";
					echo "起送价格：".number_format(get_minprice($item['shop'])->min_price,2);
					echo "</th>";
					echo "<th colspan='1' style=\"text-align:right;font-weight:bold; \">";
					echo  "<span>￥".number_format($$item['shop'],2)."</span>";
					echo "</th>";
					echo "</tr>";
					//如果$item['shop']==1则是体验店铺，开通在线订餐功能
if(
					abs($now-get_shop($item['shop'])->linktime>60)
					&&
					$item['shop']!='1'
					&&
					(get_shop($item['shop'])->online==2 &&
					((strtotime(get_shop($item['shop'])->swstart)<$time && strtotime(get_shop($item['shop'])->swend)>$time)||
					(strtotime(get_shop($item['shop'])->xwstart)<$time && strtotime(get_shop($item['shop'])->xwend)>$time))
					))
					{
						echo "<tr class='outline' style='display:none'>";
						if(!empty($_SESSION['email'])){
							echo "<td colspan='3'><font size='2' color='#F30'>订购热线:".get_shop($item['shop'])->shoptel."</font>";
						}else{
							echo "<td colspan='3'><font size='2' color='#F30'>注册会员即可查看订餐热线</font>";
						}
						echo "</td>";
						echo "</tr>";
						//有餐店离线
						$mark=1;
						echo "<input type='hidden' id='mark' value='".$mark."' />";
					}
					$shop=$item['shop'];
				}
			
				echo "\t\t\t\t<tr>\n";
				
				// ADD THE ITEM ID AS THE INPUT ID ATTRIBUTE
				// THIS ALLOWS US TO ACCESS THE ITEM ID VIA JAVASCRIPT ON QTY CHANGE, AND THEREFORE UPDATE THE CORRECT ITEM
				// NOTE THAT THE ITEM ID IS ALSO PASSED AS A SEPARATE FIELD FOR PROCESSING VIA PHP
				echo "\t\t\t\t\t<td class='jcart-item-qty'>\n";
				echo "\t\t\t\t\t\t<input type='text' size='2' id='jcart-item-id-" . $item['id'] . "' name='jcart_item_qty[ ]' value='" . $item['qty'] . "' />\n";
				echo "\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t<td class='jcart-item-name'>\n";
				//if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 6.0"))
                //{
				
				echo "\t\t\t\t\t\t" .$item['name']. "<input type='hidden' name='jcart_item_name[ ]' value='" . $item['name']. "' />\n";
				/*}else
				{
				echo "\t\t\t\t\t\t" . mb_convert_encoding($item['name'],'gb2312','utf-8') . "<input type='hidden' name='jcart_item_name[ ]' value='" . mb_convert_encoding($item['name'],'gb2312','utf-8') . "' />\n";
				
				}*/
				echo "\t\t\t\t\t\t<input type='hidden' name='jcart_item_id[ ]' value='" . $item['id'] . "' />\n";
				echo "\t\t\t\t\t</td>\n";
				echo "\t\t\t\t\t<td class='jcart-item-price'>\n";
				echo "\t\t\t\t\t\t<span>" . $text['currency_symbol'] . number_format($item['subtotal'],2) . "</span><input type='hidden' name='jcart_item_price[ ]' value='" . $item['price'] . "' />";
				echo "\t\t\t\t\t\t<a class='jcart-remove' href='?jcart_remove=" . $item['id'] . "'>" . $text['remove_link'] . "</a>\n";
				echo "\t\t\t\t\t</td>\n";
				echo "\t\t\t\t</tr>\n";
				}
			}

		// THE CART IS EMPTY
		else
			{
			echo "\t\t\t\t<tr><td colspan='3' class='empty'>" . $text['empty_message'] . "</td></tr>\n";
			}

		// DISPLAY THE CART FOOTER
		echo "\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t<th id='jcart-footer' colspan='3'>\n";

		// IF THIS IS THE CHECKOUT HIDE THE CART CHECKOUT BUTTON
		if ($is_checkout !== true && $mark!=1 )
		{
			if ($button['checkout']) { $input_type = 'submit'; $src = ' src="' . $button['checkout'] . '" alt="' . $text['checkout_button'] . '" title="" ';	}
			echo "\t\t\t\t\t\t<input type='" . $input_type . "' " . $src . "id='jcart-checkout' name='jcart_checkout' class='jcart-button' value='" . $text['checkout_button'] . "' />\n";
			}elseif($mark==1 )
			{
			echo "\t\t\t\t\t\t<input type='button' id='jcart-checkout' value='查看订餐热线' onclick='showtelephone()'/>\n";
			}

		echo "\t\t\t\t\t\t<span id='jcart-subtotal'>" . $text['subtotal'] . ": <strong>" . $text['currency_symbol'] . number_format($this->total,2) . "</strong></span>\n";   
		echo "\t\t\t\t\t</th>\n";
		echo "\t\t\t\t</tr>\n";
		echo "\t\t\t</table>\n\n";

		echo "\t\t\t<div class='jcart-hide'>\n";
		if ($button['update']) { $input_type = 'image'; $src = ' src="' . $button['update'] . '" alt="' . $text['update_button'] . '" title="" ';	}
		echo "\t\t\t\t<input type='" . $input_type . "' " . $src ."name='jcart_update_cart' value='" . $text['update_button'] . "' class='jcart-button' />\n";
		if ($button['empty']) { $input_type = 'image'; $src = ' src="' . $button['empty'] . '" alt="' . $text['empty_button'] . '" title="" ';	}
		echo "\t\t\t\t<input type='" . $input_type . "' " . $src ."name='jcart_empty' value='" . $text['empty_button'] . "' class='jcart-button' />\n";
		//echo "<font color=red><b>您的浏览器版本太低啦，请按F5键刷新</b></font>";
		echo "\t\t\t</div>\n";

		// IF THIS IS THE CHECKOUT DISPLAY THE PAYPAL CHECKOUT BUTTON
		if ($is_checkout == true)
			{
			// HIDDEN INPUT ALLOWS US TO DETERMINE IF WE'RE ON THE CHECKOUT PAGE
			// WE NORMALLY CHECK AGAINST REQUEST URI BUT AJAX UPDATE SETS VALUE TO jcart-relay.php
			echo "\t\t\t<input type='hidden' id='jcart-is-checkout' name='jcart_is_checkout' value='true' />\n";

			// SEND THE URL OF THE CHECKOUT PAGE TO jcart-gateway.php
			// WHEN JAVASCRIPT IS DISABLED WE USE A HEADER REDIRECT AFTER THE UPDATE OR EMPTY BUTTONS ARE CLICKED
			$protocol = 'http://'; if (!empty($_SERVER['HTTPS'])) { $protocol = 'https://'; }
			echo "\t\t\t<input type='hidden' id='jcart-checkout-page' name='jcart_checkout_page' value='" . $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "' />\n";

			// PAYPAL CHECKOUT BUTTON
		
			}
		echo "\t\t</fieldset>\n";
		//echo "<input type='hidden' name='total' value='".$this->total."'/>";
		echo "\t</form>\n";

		// IF UPDATING AN ITEM, FOCUS ON ITS QTY INPUT AFTER THE CART IS LOADED (DOESN'T SEEM TO WORK IN IE7)
		if ($_POST['jcart_update_item'])
			{
			echo "\t" . '<script type="text/javascript">$(function(){$("#jcart-item-id-' . $_POST['item_id'] . '").focus()});</script>' . "\n";
			}

		echo "</div>\n<!-- END JCART -->\n";
		echo "</div>";
		}
	}
?>
