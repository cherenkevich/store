;( function( $, window, document, undefined ) {

    var isOnboarded = 0;

    // $( '.carousel' )
    //     .animate({ scrollLeft: "+=100" }, 500 );

    if ( $( '.carousel' ).length ) {
        
        update();
        $( window )
            .on( 'resize', update );
            // .on( 'scroll', onboarding );

    }

    function update() {
        var left = $( '.header__logo' ).position().left;
        $( '.carousel .carousel__image:eq(0)' ).css( 'paddingLeft', left + 'px' );
    }

    function onboarding() {
        var windowOffset = window.scrollY;
        var carouselOffset = $( '.carousel__wrapper' ).scrollLeft();

        if ( windowOffset == 1 && carouselOffset == 0 && !isOnboarded ) {

            isOnboarded = 1;
            
            $( '.carousel__wrapper' ).scrollLeft(100);
        }
    }

} )( jQuery, window, document );
