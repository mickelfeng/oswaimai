<?php

// JCART v1.1
// http://conceptlogic.com/jcart/

// DEFAULT CART TEXT USED IF NOT OVERRIDDEN IN jcart-config.php
// DEFAULTS MUST BE AVAILABLE TO jcart.php AND jcart-javascript.php
// INCLUDED AS A SEPARATE FILE TO SIMPLIFY USER CONFIG

if (!$jcart['path']) die('The path to jCart isn\'t set. Please see <strong>jcart-config.php</strong> for more info.');

if (!$jcart['text']['cart_title']) $jcart['text']['cart_title']							= '我的餐车';
if (!$jcart['text']['single_item']) $jcart['text']['single_item']						= '';
if (!$jcart['text']['multiple_items']) $jcart['text']['multiple_items']					= '';
if (!$jcart['text']['currency_symbol']) $jcart['text']['currency_symbol']				= '￥';
if (!$jcart['text']['subtotal']) $jcart['text']['subtotal']								= '总价';

if (!$jcart['text']['update_button']) $jcart['text']['update_button']					= 'update';
if (!$jcart['text']['checkout_button']) $jcart['text']['checkout_button']				= '下订单';
if (!$jcart['text']['checkout_paypal_button']) $jcart['text']['checkout_paypal_button']	= '确认订餐';
if (!$jcart['text']['remove_link']) $jcart['text']['remove_link']						= '删除';
if (!$jcart['text']['empty_button']) $jcart['text']['empty_button']						= 'empty';
if (!$jcart['text']['empty_message']) $jcart['text']['empty_message']					= '您的餐车目前没有餐品!';
if (!$jcart['text']['item_added_message']) $jcart['text']['item_added_message']			= '点餐成功!';

if (!$jcart['text']['price_error']) $jcart['text']['price_error']						= 'Invalid price format!';
if (!$jcart['text']['quantity_error']) $jcart['text']['quantity_error']					= '餐品数量必须为数字!';
if (!$jcart['text']['checkout_error']) $jcart['text']['checkout_error']					= 'Your order could not be processed!';

?>
