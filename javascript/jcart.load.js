function empty()
{
	$.ajax({
			type: "POST",dataType : "text",async : false,url: "./jcart/jcart-relay.php",
			data: {"empty" : "1"},
			success: function(data){$('#sidebar').html(data);scall();},
			error : function(res,msg,err) {alert(msg);}
		});
}

function jiajian(id,tag)
{
	if(tag==1)
	{
		var counts = parseInt($('#jcart-item-id-'+id).val())+1;
	}else
	{
		var counts = parseInt($('#jcart-item-id-'+id).val())-1;
	}
	$('#jcart-item-id-'+id).val(counts);	
	var isCheckout = $('#jcart-is-checkout').val();
	// THE ID OF THE ITEM TO UPDATE
	updateId = id;
	// GET THE NEW QTY
	var updateQty = counts;

	// AS LONG AS THE VISITOR HAS ENTERED A QTY
	if (updateQty !== '')
	{
		$.post('jcart/jcart-relay.php', { "item_id": updateId, "item_qty": updateQty, "jcart_update_item": 'update', "jcart_is_checkout": isCheckout }, function(data) {$('#sidebar').html(data);scall();});
	}
}
// WHEN THE DOCUMENT IS READY
$(document).ready(function() {
	/**********************************************************************
	Tooltips based on Wayfarer Tooltip 1.0.2
	(c) 2006-2009 Abel Mohler
	http://www.wayfarerweb.com/wtooltip.php
	**********************************************************************/
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
						if ( o.content ){
							display = "block";
						}else{
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
	$('.jcart input[name="my-add-button"]').jcartTooltip({content: 'µã²Í³É¹¦!', fadeIn: 500, fadeOut: 350 });

	// CHECK IF THERE ARE ANY ITEMS IN THE CART
	var cartHasItems = $('td.jcart-item-qty').html();
	if(cartHasItems === null)
		{
		// DISABLE THE PAYPAL CHECKOUT BUTTON
		$('#jcart-paypal-checkout').attr('disabled', 'disabled');
		}

	// HIDE THE UPDATE AND EMPTY BUTTONS SINCE THESE ARE ONLY USED WHEN JAVASCRIPT IS DISABLED

	// DETERMINE IF THIS IS THE CHECKOUT PAGE BY CHECKING FOR HIDDEN INPUT VALUE
	// SENT VIA AJAX REQUEST TO jcart.php WHICH DECIDES WHETHER TO DISPLAY THE CART CHECKOUT BUTTON OR THE PAYPAL CHECKOUT BUTTON BASED ON ITS VALUE
	// WE NORMALLY CHECK AGAINST REQUEST URI BUT AJAX UPDATE SETS VALUE TO jcart-relay.php
	var isCheckout = $('#jcart-is-checkout').val();

	// IF THIS IS NOT THE CHECKOUT THE HIDDEN INPUT DOESN'T EXIST AND NO VALUE IS SET
	if (isCheckout !== 'true') { isCheckout = 'false'; }


	// WHEN AN ADD-TO-CART FORM IS SUBMITTED
	$('form.jcart').submit(function(){

		// GET INPUT VALUES FOR USE IN AJAX POST
		var itemId = $(this).find('input[name=my-item-id]').val();
		var itemPrice = $(this).find('input[name=my-item-price]').val();
		var itemName = $(this).find('input[name=my-item-name]').val();
		var itemShop = $(this).find('input[name=my-item-shop]').val();
		var itemQty = $(this).find('input[name=my-item-qty]').val();
		var itemAdd = $(this).find('input[name=my-add-button]').val();

		// SEND ITEM INFO VIA POST TO INTERMEDIATE SCRIPT WHICH CALLS jcart.php AND RETURNS UPDATED CART HTML
		$.post('jcart/jcart-relay.php', { "my-item-id": itemId, "my-item-price": itemPrice, "my-item-name": itemName, "my-item-shop": itemShop,"my-item-qty": itemQty, "my-add-button" : itemAdd }, function(data) {

			// REPLACE EXISTING CART HTML WITH UPDATED CART HTML
			$('#sidebar').html(data);scall();
			
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
		$.get('jcart/jcart-relay.php', { "jcart_remove": removeId, "jcart_is_checkout":  isCheckout },
			function(data) {

			// REPLACE EXISTING CART HTML WITH UPDATED CART HTML
			$('#sidebar').html(data);scall();
			
			});

		// PREVENT DEFAULT LINK ACTION
		return false;
	});


	// WHEN AN ITEM QTY CHANGES
	// CHANGE EVENT IS NOT CURRENTLY SUPPORTED BY LIVE METHOD
	// STILL WORKS IN MOST BROWSERS, BUT NOT INTERNET EXPLORER
	// INSTEAD WE SIMULATE THE CHANGE EVENT USING KEYUP AND SET A DELAY BEFORE UPDATING THE CART
	$('#jcart input[type="text"]').live('change', function(){

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
				$.post('jcart/jcart-relay.php', { "item_id": updateId, "item_qty": updateQty, "jcart_update_item": 'update', "jcart_is_checkout": isCheckout }, function(data) {

					// REPLACE EXISTING CART HTML WITH UPDATED CART HTML
					$('#sidebar').html(data);scall();
					
					});

				}, 1000);
			}
		$(this).keydown(function(){
			window.clearTimeout(updateDelay);
			});
		});


	// END THE DOCUMENT READY FUNCTION
	});