<?php
require_once('jcart-config.php');
require_once('jcart-defaults.php');

// OUTPUT PHP FILE AS JAVASCRIPT
//header('content-type:application/x-javascript');
header('Content-Type:application/x-javascript;charset=gb2312');
// PREVENT CACHING
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// CONTINUE THE SESSION
session_start();

?>

// WHEN THE DOCUMENT IS READY
$(document).ready(function() {
	/**********************************************************************
	Tooltips based on Wayfarer Tooltip 1.0.2
	(c) 2006-2009 Abel Mohler
	http://www.wayfarerweb.com/wtooltip.php
	**********************************************************************/
    alert('²âÊÔ');
	( function( $ ) {
		$.fn.jcartTooltip = function( o, callback ) {
			o = $.extend( {
				content: null,
				follow: true,
				auto: true,
				fadeIn: 0,
				fadeOut: 0,
				appendTip: document.body,
				offsetY: 25,
				offsetX: -10,
				style: {},
				id: 'jcart-tooltip'
			}, o || {});

			if ( !o.style && typeof o.style != "object" )
				{
				o.style = {}; o.style.zIndex = "1000";
				}
			else
				{
				o.style = $.extend( {}, o.style || {});
			}

			o.style.display = "none";
			o.style.position = "absolute";

			var over = {};
			var maxed = false;
			var tooltip = document.createElement( 'div' );

            tooltip.id = o.id;

			for ( var p in o.style ) { tooltip.style[p] = o.style[p]; }

			function fillTooltip( condition ) { if ( condition ) { $( tooltip ).html( o.content ); }}

			fillTooltip( o.content && !o.ajax );
			$( tooltip ).appendTo( o.appendTip );

			return this.each( function() {
				this.onclick = function( ev ) {
					function _execute() {
						var display;
						if ( o.content )
							{
							display = "block";
							}
						else
							{
							display = "none";
							}
						if ( display == "block" && o.fadeIn )
							{
							$( tooltip ).fadeIn( o.fadeIn );

							setTimeout(function(){
								$( tooltip ).fadeOut( o.fadeOut );
								}, 1000);
							}
						}
					_execute();
					};

				this.onmousemove = function( ev ) {
					var e = ( ev ) ? ev : window.event;
					over = this;
					if ( o.follow ) {
						var scrollY = $( window ).scrollTop();
						var scrollX = $( window ).scrollLeft();
						var top = e.clientY + scrollY + o.offsetY;
						var left = e.clientX + scrollX + o.offsetX;
						var maxLeft = $( window ).width() + scrollX - $( tooltip ).outerWidth();
						var maxTop = $( window ).height() + scrollY - $( tooltip ).outerHeight();
						maxed = ( top > maxTop || left > maxLeft ) ? true : false;

						if ( left - scrollX <= 0 && o.offsetX < 0 )
							{
							left = scrollX;
							}
						else if ( left > maxLeft )
							{
							left = maxLeft;
							}
						if ( top - scrollY <= 0 && o.offsetY < 0 )
							{
							top = scrollY;
							}
						else if ( top > maxTop )
							{
							top = maxTop;
							}

						tooltip.style.top = top + "px";
						tooltip.style.left = left + "px";
						}
					};

				this.onmouseout = function() {
					$( tooltip ).css('display', 'none');
				};



			});
		};
	})( jQuery );

	// SHOW A TOOLTIP AFTER VISITOR CLICKS THE ADD-TO-CART
	// IN CASE THE CART IS OFF SCREEN
	$('.jcart input[name="<?php echo $jcart['item_add'];?>"]').jcartTooltip({content: '<?php echo $jcart['text']['item_added_message'];?>', fadeIn: 500, fadeOut: 350 });

	// CHECK IF THERE ARE ANY ITEMS IN THE CART
	var cartHasItems = $('td.jcart-item-qty').html();
	if(cartHasItems === null)
		{
		// DISABLE THE PAYPAL CHECKOUT BUTTON
		$('#jcart-paypal-checkout').attr('disabled', 'disabled');
		}

	// HIDE THE UPDATE AND EMPTY BUTTONS SINCE THESE ARE ONLY USED WHEN JAVASCRIPT IS DISABLED
	$('.jcart-hide').remove();

	// DETERMINE IF THIS IS THE CHECKOUT PAGE BY CHECKING FOR HIDDEN INPUT VALUE
	// SENT VIA AJAX REQUEST TO jcart.php WHICH DECIDES WHETHER TO DISPLAY THE CART CHECKOUT BUTTON OR THE PAYPAL CHECKOUT BUTTON BASED ON ITS VALUE
	// WE NORMALLY CHECK AGAINST REQUEST URI BUT AJAX UPDATE SETS VALUE TO jcart-relay.php
	var isCheckout = $('#jcart-is-checkout').val();

	// IF THIS IS NOT THE CHECKOUT THE HIDDEN INPUT DOESN'T EXIST AND NO VALUE IS SET
	if (isCheckout !== 'true') { isCheckout = 'false'; }


	// WHEN AN ADD-TO-CART FORM IS SUBMITTED
	$('form.jcart').submit(function(){

		// GET INPUT VALUES FOR USE IN AJAX POST
		var itemId = $(this).find('input[name=<?php echo $jcart['item_id']?>]').val();
		var itemPrice = $(this).find('input[name=<?php echo $jcart['item_price']?>]').val();
		var itemName = $(this).find('input[name=<?php echo $jcart['item_name']?>]').val();
		var itemShop = $(this).find('input[name=<?php echo $jcart['item_shop']?>]').val();
		var itemQty = $(this).find('input[name=<?php echo $jcart['item_qty']?>]').val();
		var itemAdd = $(this).find('input[name=<?php echo $jcart['item_add']?>]').val();

		// SEND ITEM INFO VIA POST TO INTERMEDIATE SCRIPT WHICH CALLS jcart.php AND RETURNS UPDATED CART HTML
		$.post('<?php echo $jcart['path'];?>jcart-relay.php', { "<?php echo $jcart['item_id']?>": itemId, "<?php echo $jcart['item_price']?>": itemPrice, "<?php echo $jcart['item_name']?>": itemName, "<?php echo $jcart['item_shop']?>": itemShop,"<?php echo $jcart['item_qty']?>": itemQty, "<?php echo $jcart['item_add']?>" : itemAdd }, function(data) {

			// REPLACE EXISTING CART HTML WITH UPDATED CART HTML
			$('#jcart').html(data);
			$('.jcart-hide').remove();

			});

		// PREVENT DEFAULT FORM ACTION
		return false;

		});


	// WHEN THE VISITOR HITS THEIR ENTER KEY
	// THE UPDATE AND EMPTY BUTTONS ARE ALREADY HIDDEN
	// BUT THE VISITOR MAY UPDATE AN ITEM QTY, THEN HIT THEIR ENTER KEY BEFORE FOCUSING ON ANOTHER ELEMENT
	// THIS MEANS WE'D HAVE TO UPDATE THE ENTIRE CART RATHER THAN JUST THE ITEM WHOSE QTY HAS CHANGED
	// PREVENT ENTER KEY FROM SUBMITTING FORM SO USER MUST CLICK CHECKOUT OR FOCUS ON ANOTHER ELEMENT WHICH TRIGGERS CHANGE FUNCTION BELOW
	$('#jcart').keydown(function(e) {

		// IF ENTER KEY
		if(e.which == 13) {

		// PREVENT DEFAULT ACTION
		return false;
		}
	});


	// JQUERY live METHOD MAKES FUNCTIONS BELOW AVAILABLE TO ELEMENTS ADDED DYNAMICALLY VIA AJAX

	// WHEN A REMOVE LINK IS CLICKED
	$('#jcart a').live('click', function(){

		// GET THE QUERY STRING OF THE LINK THAT WAS CLICKED
		var queryString = $(this).attr('href');
		queryString = queryString.split('=');

		// THE ID OF THE ITEM TO REMOVE
		var removeId = queryString[1];

		// SEND ITEM ID VIA GET TO INTERMEDIATE SCRIPT WHICH CALLS jcart.php AND RETURNS UPDATED CART HTML
		$.get('<?php echo $jcart['path'];?>jcart-relay.php', { "jcart_remove": removeId, "jcart_is_checkout":  isCheckout },
			function(data) {

			// REPLACE EXISTING CART HTML WITH UPDATED CART HTML
			$('#jcart').html(data);
			$('.jcart-hide').remove();
			});

		// PREVENT DEFAULT LINK ACTION
		return false;
	});


	// WHEN AN ITEM QTY CHANGES
	// CHANGE EVENT IS NOT CURRENTLY SUPPORTED BY LIVE METHOD
	// STILL WORKS IN MOST BROWSERS, BUT NOT INTERNET EXPLORER
	// INSTEAD WE SIMULATE THE CHANGE EVENT USING KEYUP AND SET A DELAY BEFORE UPDATING THE CART
	$('#jcart input[type="text"]').live('keyup', function(){

		// GET ITEM ID FROM THE ITEM QTY INPUT ID VALUE, FORMATTED AS jcart-item-id-n
		var updateId = $(this).attr('id');
		updateId = updateId.split('-');

		// THE ID OF THE ITEM TO UPDATE
		updateId = updateId[3];

		// GET THE NEW QTY
		var updateQty = $(this).val();

		// AS LONG AS THE VISITOR HAS ENTERED A QTY
		if (updateQty !== '')
			{
			// UPDATE THE CART ONE SECOND AFTER KEYUP
			var updateDelay = setTimeout(function(){

				// SEND ITEM INFO VIA POST TO INTERMEDIATE SCRIPT WHICH CALLS jcart.php AND RETURNS UPDATED CART HTML
				$.post('<?php echo $jcart['path'];?>jcart-relay.php', { "item_id": updateId, "item_qty": updateQty, "jcart_update_item": '<?php echo $jcart['text']['update_button'];?>', "jcart_is_checkout": isCheckout }, function(data) {

					// REPLACE EXISTING CART HTML WITH UPDATED CART HTML
					$('#jcart').html(data);
					$('.jcart-hide').remove();
					});

				}, 1000);
			}

		// IF THE VISITOR PRESSES ANOTHER KEY BEFORE THE TIMER HAS EXPIRED, CLEAR THE TIMER
		// THE NEW KEYDOWN RESULTS IN A NEW KEYUP, TRIGGERING THE KEYUP FUNCTION AGAIN AND RESETTING THE TIMER
		// REPEATS UNTIL THE USER DOES NOT PRESS A KEY BEFORE THE TIMER EXPIRES IN WHICH CASE THE AJAX POST IS EXECUTED
		// THIS PREVENTS THE CART FROM BEING UPDATED ON EVERY KEYSTROKE
		$(this).keydown(function(){
			window.clearTimeout(updateDelay);
			});
		});


	// END THE DOCUMENT READY FUNCTION
	});
