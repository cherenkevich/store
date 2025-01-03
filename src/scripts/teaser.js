;( function( $, window, document, undefined ) {

    var browsing;

    var teaserDown = $( '.teaser' )
        .waypoint( function( direction ) {     
            
            if ( direction == 'down' ) {
                var teaser = $( this )[0].element;
                var $teaser = $( teaser );

                if ( ! $teaser.hasClass( 'teaser--browsing' ) ) {
                    clearInterval( browsing );
                    resetBrowsing();
                    browsing = setInterval( showBrowsing, 300, $teaser );
                }
            }
        }, {
            offset: window.innerWidth > window.innerHeight ? '30%' : '40%'
        } );

    var teaserUp = $( '.teaser' )
        .waypoint( function( direction ) {     
            
            if ( direction == 'up' ) {
                var teaser = $( this )[0].element;
                var $teaser = $( teaser );

                if ( ! $teaser.hasClass( 'teaser--browsing' ) ) {
                    clearInterval( browsing );
                    resetBrowsing();
                    browsing = setInterval( showBrowsing, 300, $teaser );
                }
            }
        }, {
            offset: window.innerWidth > window.innerHeight ? '-30%' : '10%'
        } );        

    $( window )
        .on( 'scroll', function () {
            if ( window.scrollY < 50 ) {
                clearInterval( browsing );
                resetBrowsing();
            }
            
        } )

    function showBrowsing( $teaser ) {
        
        $teaser
            .addClass( 'teaser--browsing' );

        var $top = $teaser.find( '.teaser__image--top' );
        var $next = $top.next();

        if ( ! $next.length) {
            $next = $teaser.find( '.teaser__image:eq(0)' );
        }        
        
        $top
            .removeClass( 'teaser__image--top' );
        
        $next
            .addClass( 'teaser__image--top' );
    }

    function resetBrowsing( $teaser ) {

        $( '.teaser--browsing' )
            .removeClass( 'teaser--browsing' );

        $( '.teaser__image--top' )
            .removeClass( 'teaser__image--top' );
        
        $( '.teaser__image--cover' )
            .addClass( 'teaser__image--top' );
    }

} )( jQuery, window, document );
