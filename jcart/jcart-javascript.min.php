<?php

// JCART v1.1
// http://conceptlogic.com/jcart/

// INCLUDE CONFIG SO THIS SCRIPT HAS ACCESS USER FIELD NAMES
require_once('jcart-config.php');

// INCLUDE DEFAULT VALUES SINCE WE NEED TO PASS THE VALUE OF THE UPDATE BUTTON BACK TO jcart.php IF UPDATING AN ITEM QTY
// IF NO VALUE IS SET IN CONFIG, THERE MUST BE A DEFAULT VALUE SINCE SIMPLY CHECKING FOR THE VAR ITSELF FAILS
require_once('jcart-defaults.php');

// OUTPUT PHP FILE AS JAVASCRIPT
header('content-type:application/x-javascript;charset=gb2312');

// PREVENT CACHING
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// CONTINUE THE SESSION
session_start();

?>
$(function(){(function($){$.fn.jcartTooltip=function(o,i){o=$.extend({content:null,follow:true,auto:true,fadeIn:0,fadeOut:0,appendTip:document.body,offsetY:25,offsetX:-10,style:{},id:'jcart-tooltip'},o||{});if(!o.style&&typeof o.style!="object"){o.style={};o.style.zIndex="1000"}else{o.style=$.extend({},o.style||{})}o.style.display="none";o.style.position="absolute";var j={};var k=false;var l=document.createElement('div');l.id=o.id;for(var p in o.style){l.style[p]=o.style[p]}function fillTooltip(a){if(a){$(l).html(o.content)}}fillTooltip(o.content&&!o.ajax);$(l).appendTo(o.appendTip);return this.each(function(){this.onclick=function(b){function _execute(){var a;if(o.content){a="block"}else{a="none"}if(a=="block"&&o.fadeIn){$(l).fadeIn(o.fadeIn);setTimeout(function(){$(l).fadeOut(o.fadeOut)},1000)}}_execute()};this.onmousemove=function(a){var e=(a)?a:window.event;j=this;if(o.follow){var b=$(window).scrollTop();var c=$(window).scrollLeft();var d=e.clientY+b+o.offsetY;var f=e.clientX+c+o.offsetX;var g=$(window).width()+c-$(l).outerWidth();var h=$(window).height()+b-$(l).outerHeight();k=(d>h||f>g)?true:false;if(f-c<=0&&o.offsetX<0){f=c}else if(f>g){f=g}if(d-b<=0&&o.offsetY<0){d=b}else if(d>h){d=h}l.style.top=d+"px";l.style.left=f+"px"}};this.onmouseout=function(){$(l).css('display','none')}})}})(jQuery);$('.jcart input[name="<?php echo $jcart['item_add'];?>"]').jcartTooltip({content:'<?php echo $jcart['text']['item_added_message'];?>',fadeIn:500,fadeOut:350});var m=$('td.jcart-item-qty').html();if(m===null){$('#jcart-paypal-checkout').attr('disabled','disabled')}$('.jcart-hide').remove();var n=$('#jcart-is-checkout').val();if(n!=='true'){n='false'}$('form.jcart').submit(function(){var b=$(this).find('input[name=<?php echo $jcart['item_id']?>]').val();var c=$(this).find('input[name=<?php echo $jcart['item_price']?>]').val();var d=$(this).find('input[name=<?php echo $jcart['item_name']?>]').val();var e=$(this).find('input[name=<?php echo $jcart['item_qty']?>]').val();var f=$(this).find('input[name=<?php echo $jcart['item_add']?>]').val();$.post('<?php echo $jcart['path'];?>jcart-relay.php',{"<?php echo $jcart['item_id']?>":b,"<?php echo $jcart['item_price']?>":c,"<?php echo $jcart['item_name']?>":d,"<?php echo $jcart['item_qty']?>":e,"<?php echo $jcart['item_add']?>":f},function(a){$('#jcart').html(a);$('.jcart-hide').remove()});return false});$('#jcart').keydown(function(e){if(e.which==13){return false}});$('#jcart a').live('click',function(){var b=$(this).attr('href');b=b.split('=');var c=b[1];$.get('<?php echo $jcart['path'];?>jcart-relay.php',{"jcart_remove":c,"jcart_is_checkout":n},function(a){$('#jcart').html(a);$('.jcart-hide').remove()});return false});$('#jcart input[type="text"]').live('keyup',function(){var b=$(this).attr('id');b=b.split('-');b=b[3];var c=$(this).val();if(c!==''){var d=setTimeout(function(){$.post('<?php echo $jcart['path'];?>jcart-relay.php',{"item_id":b,"item_qty":c,"jcart_update_item":'<?php echo $jcart['text']['update_button'];?>',"jcart_is_checkout":n},function(a){$('#jcart').html(a);$('.jcart-hide').remove()})},1000)}$(this).keydown(function(){window.clearTimeout(d)})})});
