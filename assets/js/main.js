(function(){
		
	var cart = document.getElementsByClassName('js-cd-cart');
	initCartEvents();

	function initCartEvents() {
		// open/close cart
		cart[0].getElementsByClassName('cd-cart__trigger')[0].addEventListener('click', function(event){
			event.preventDefault();
			toggleCart();
		});
			
		
	};

	function toggleCart(bool) { // toggle cart visibility
		var cartIsOpen = ( typeof bool === 'undefined' ) ? Util.hasClass(cart[0], 'cd-cart--open') : bool;
	
		if( cartIsOpen ) {
			Util.removeClass(cart[0], 'cd-cart--open');
			//reset undo
			if(cartTimeoutId) clearInterval(cartTimeoutId);
			Util.removeClass(cartUndo, 'cd-cart__undo--visible');
			removePreviousProduct(); // if a product was deleted, remove it definitively from the cart

			setTimeout(function(){
				cartBody.scrollTop = 0;
				//check if cart empty to hide it
				if( Number(cartCountItems[0].innerText) == 0) Util.addClass(cart[0], 'cd-cart--empty');
			}, 500);
		} else {
			Util.addClass(cart[0], 'cd-cart--open');
		}
	};

})();