;( function( $, window, document, undefined ) {

    var cart = [];
    var $cartHeader = $( ".cart__logo span" );
    var productID;
    var $cartHeading = $( ".html--cart .heading span" );
    var $total = $( ".list__row--total .slot__right .price" );
    var $shipping = $( ".list__row--shipping" );
    var shippingPrice = $shipping.find( ".slot" ).data( "price" );
    var slotPrice;
 
    $( '[data-product]' )
        .on( "click", function () {
            productID = $( this ).data( 'product' );
            addToCart( productID );
            updateCartHeader();
        } );

    $( '[data-cart-remove]' )
        .on( "click", function () {
            productID = $( this ).data( 'cart-remove' );

            removeFromCart( productID );
            updateCartHeader();
            updateCartHeading();

            setTimeout( updateTotal, 1 );
            ;
        } );

    $( '[data-restore]' )
        .on( "click", function () {
            productID = $( this ).data( 'restore' );
            addToCart( productID );
            updateCartHeader();
            updateCartHeading();
            setTimeout( updateTotal, 1 );
        } );

    if ( $( '.html' ).hasClass( 'html--success' ) ) {
        emptyCart();
    }

    function emptyCart() {
        var cart = [];
        cart = JSON.stringify( cart );
        setCookie( 'cart', cart, 9999999 );
        updateCartHeader();
    }

    function removeFromCart( productID ) {
        
        var cartStorage = getCookie( 'cart' );
        var cart = JSON.parse( cartStorage );

        cart = cart.filter(item => item !== productID);

        var cart = JSON.stringify( cart );
        setCookie( 'cart', cart, 9999999 );
    }

    function updateTotal() {
        var total = 0;
        var requiresShipping = false;

        $( ".list--cart .list__row--item .slot" )
            .each( function() {

                if ( ! $( this ).find( ".slot__status:checked" ).length ) {
                    var slotPrice = $( this ).data( "price" );
                    var slotType = $( this ).data( "type" );
                    total += slotPrice;

                    if ( slotType == "paper" ) {
                        requiresShipping = true;
                    }
                }

            } );

        if ( requiresShipping ) {
            total += shippingPrice;
            $shipping
                .show();
        } else {
            $shipping
                .hide();
        }

        $total
            .text( total + " €" );
    }

    function addToCart( productID ) {

        var cart = [];

        var cartStorage = getCookie( 'cart' );

        if ( cartStorage !== null ) {
            var cart = JSON.parse( cartStorage );
        }

        if(cart.indexOf(productID) === -1) {
            cart.push(productID);
        }

        cart = JSON.stringify( cart );
        setCookie( 'cart', cart, 9999999 );
    }

    function updateCartHeader() {

        var cart = getCookie( 'cart' );
        var cart = JSON.parse( cart );
        var cartQuantity = cart.length;

        if ( cartQuantity ) {
            $cartHeader
                .text( cartQuantity )
                .closest( '.cart' )
                .removeClass( 'cart--empty' );
        } else {
            $cartHeader
                .text( '' )
                .closest( '.cart' )
                .addClass( 'cart--empty' );
        }
    }

    function updateCartHeading() {

        var cart = getCookie( 'cart' );
        var cart = JSON.parse( cart );
        var cartQuantity = cart.length;

        $cartHeading.text( cartQuantity + " " + ( cartQuantity == 1 ? "item" : "items" ) );
    }

    function setCookie(name, value, days = 7, path = '/') {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000)); // expires in 'days'
        const expiresStr = `expires=${expires.toUTCString()}`;
        document.cookie = `${name}=${value}; ${expiresStr}; path=${path}`;
    }
    
    // Get a cookie
    function getCookie(name) {
        const nameEq = `${name}=`;
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i].trim();
            if (cookie.indexOf(nameEq) === 0) {
                return cookie.substring(nameEq.length, cookie.length); // Return the cookie value
            }
        }
        return null;  // Cookie not found
    }

} )( jQuery, window, document );
