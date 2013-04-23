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
ini_set('date.timezone','PRC');

// USER CONFIG
include_once('db_fns.php');
include_once('jcart-config.php');
// DEFAULT CONFIG VALUES
include_once('jcart-defaults.php');

// JCART
// Returns true if $string is valid UTF-8 and false otherwise. 
function is_utf8($word) 
{ 
	return preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true?true:false;
} 
// function is_utf8 
function get_shop($id) 
{
	// query database for the name for a  bulid
	$conn = db_connect();
	$query = "select `shopname`,`linktime`,`shoptel`,`online`,`swstart`,`swend`,`xwstart`,`xwend` from wm_shopinfo where shopid = '".$id."'";
	$result = @$conn->query($query);
	$row = $result->fetch_object();
	return $row;
} 
function get_minprice($sid)
{
   $bulid  = isset($_COOKIE['bid'])?$_COOKIE['bid']:header("location:./index.php");
   $conn   = db_connect();
   $query  = "select `min_price`,`fee` from  `wm_shoplinkbul` where shopid = '".$sid."' and areaid='".$bulid."'";
   $result = @$conn->query($query);
   $row    = $result->fetch_object();
   return $row;
}
class jcart {
	var $total = 0;
	var $itemcount = 0;
	var $items = array();
	var $itemprices = array();
	var $itemqtys = array();
	var $itemname = array();
	var $itemshop = array();
	var $shopfee  = array();//餐店的起送价

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
	function get_shopfee()
	{
		return $this->shopfee;	
	}
	
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
			if($this->shopfee[$item_shop]==NULL)
			{
				$this->shopfee[$item_shop]=get_minprice($item_shop)->fee;
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
		if (preg_match("/^[0-9-]+$/i", $item_qty))
		{
			if($item_qty < 1){
				$this->del_item($item_id);
			}
			else{
				$this->itemqtys[$item_id] = $item_qty;
			}
			$this->_update_total();
			return true;
		}
	}


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
		$this->shopfee  = array();
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
				
				if($this->itemshop[$item]!=$mark)
				{
					$this->total += $this->shopfee[$this->itemshop[$item]];
					$mark = $this->itemshop[$item];
				}
			}
		}
	}
    
	// PROCESS AND DISPLAY CART
	function display_cart($jcart)
	{
		// JCART ARRAY HOLDS USER CONFIG SETTINGS
		extract($jcart);
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
		echo "\t\t\t\t\t\t<div id='jcart-title'></div> (" . $this->itemcount . $text['items_in_cart'] .")\n";
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
				$p=get_minprice($i)->min_price;
				$qsj = $$i+$this->shopfee[$i];
				echo   "<input type='hidden' name='s".$i."' value='".$qsj." '/>";
				$string.="document.mycart.s".$i.".value<$p||";
			}
			$len = strlen($string)-2;
			$string=substr($string, 0, $len);
			echo "<script>function checkForm(){if(".$string."){alert('您订的东西可能未满某一餐厅的起送价，请再检查一下？:-)');return false;}else{return true;}}</script>";
			foreach($data as $item)
			{
				$now = strtotime(date("YmdHis"));
				$time = strtotime(date("H:i:s"));
				if($item['shop']!=$shop)
				{
					$minprice = get_minprice($item['shop'])->min_price;
					echo "<tr>";
					echo "<th colspan='1' style='font-weight:bold;text-align:center'>";
					echo  get_shop($item['shop'])->shopname;
					echo "</th>";
					if($minprice!=0)
					{
						echo "<th style='font-weight:bold;text-align:center'>起送价:".number_format($minprice,2)."</th>";
						echo "<th style=\"text-align:right;font-weight:bold; \">";
						echo  "<span>￥".number_format($$item['shop']+$this->shopfee[$item['shop']],2)."</span>";
						echo "</th>";
					}else
					{
						echo "<th colspan='2' style=\"text-align:right;font-weight:bold; \">";
						echo  "<span>￥".number_format($$item['shop']+$this->shopfee[$item['shop']],2)."</span>";
						echo "</th>";	
					}
					echo "</tr>";
					
					if($this->shopfee[$item['shop']]!=0)
					{
					echo "<tr><td colspan='3' style=\"text-align:right; \">送餐费:".number_format($this->shopfee[$item['shop']],2)."</td></tr>";
					}
					//如果$item['shop']==1则是体验店铺，开通在线订餐功能
					if((abs($now-get_shop($item['shop'])->linktime<60)&&get_shop($item['shop'])->online==2)||
					$item['shop']=='1'||(get_shop($item['shop'])->online==1 &&((strtotime(get_shop($item['shop'])->swstart)<$time && strtotime(get_shop($item['shop'])->swend)>$time)||(strtotime(get_shop($item['shop'])->xwstart)<$time && strtotime(get_shop($item['shop'])->xwend)>$time))))
					{
						
					}
					else
					{
						echo "<tr class='outline' style='display:none'>";
						if(!empty($_SESSION['email'])){
							echo "<td colspan='3'><font size='2' color='#F30'>订餐热线:".get_shop($item['shop'])->shoptel."</font>";
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
				echo "<td class='jcart-item-name'>\n";
				echo "\t\t\t\t\t\t" .$item['name']. "<input type='hidden' name='jcart_item_name[ ]' value='" . $item['name']. "' />\n";
				echo "\t\t\t\t\t\t<input type='hidden' name='jcart_item_id[ ]' value='" . $item['id'] . "' />\n";
				echo "\t\t\t\t\t</td>\n";
				echo "<td class='jcart-item-qty'>";
				echo "<img src='./jcart/jian.gif' align='absmiddle' onclick='jiajian(".$item['id'].",2)'/>
				<input type='text' size='2' id='jcart-item-id-" . $item['id'] . "' name='jcart_item_qty[ ]' value='" . $item['qty'] . "' />
				<img src='./jcart/jia.gif' align='absmiddle' onclick='jiajian(".$item['id'].",1)' />";
				echo "</td>";

				echo "\t\t\t\t\t<td class='jcart-item-price'>\n";
				echo "\t\t\t\t\t\t<span>" . $text['currency_symbol'] . number_format($item['subtotal'],2) . "</span><input type='hidden' name='jcart_item_price[ ]' value='" . $item['price'] . "' />";
				echo "\t\t\t\t\t\t<a class='jcart-remove' href='?jcart_remove=" . $item['id'] . "'>" . $text['remove_link'] . "</a>\n";
				echo "\t\t\t\t\t</td>\n";
				echo "\t\t\t\t</tr>\n";
			}
		}
		else
		{
			echo "\t\t\t\t<tr><td colspan='3' class='empty'>" . $text['empty_message'] . "</td></tr>\n";
		}

		echo "<tr><td colspan='3' style='text-align:center'>";
		echo "<span id='jcart-subtotal'><strong>" . $text['subtotal'] . ":" . $text['currency_symbol'] . number_format($this->total,2) . "</strong></span>";   
		echo "</td></tr>";
		
		echo "<tr><th id='jcart-footer' colspan='3'>";
		echo "<div style='float:left'><input type='button' value='' onclick='empty()' id='emptyall' /></div>";
		
		if ($is_checkout !== true && $mark!=1 )
		{
			if ($button['checkout']) { $input_type = 'submit'; $src = ' src="' . $button['checkout'] . '" alt="' . $text['checkout_button'] . '" title="" ';	}
			echo "\t\t\t\t\t\t<input type='" . $input_type . "' " . $src . "id='jcart-checkout' name='jcart_checkout' class='jcart-button' value='' style='background:url(./jcart/order.jpg) no-repeat; width:108px ;height:30px; border:0px'/>\n";
		}elseif($mark==1 )
		{
			echo "\t\t\t\t\t\t<div style='float:right'><input type='button' id='jcart-checkout' value='查看订餐热线' onclick='showtelephone()' style='height:32px'/></div>\n";
		}
		if ($is_checkout == true)
		{
			// HIDDEN INPUT ALLOWS US TO DETERMINE IF WE'RE ON THE CHECKOUT PAGE
			// WE NORMALLY CHECK AGAINST REQUEST URI BUT AJAX UPDATE SETS VALUE TO jcart-relay.php
			echo "\t\t\t<input type='hidden' id='jcart-is-checkout' name='jcart_is_checkout' value='true' />\n";

		}
		echo "\t\t\t\t\t</th>\n";
		echo "\t\t\t\t</tr>\n";
		echo "\t\t\t</table>\n\n";
		
		echo "\t\t</fieldset>\n";
		//echo "<input type='hidden' name='total' value='".$this->total."'/>";
		echo "\t</form>\n";		
		echo "</div>\n<!-- END JCART -->\n";
		echo "</div>";
		}
	}
?>
