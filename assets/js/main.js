( function () {
	'use strict';

	var toggle = document.querySelector( '.menu-toggle' );
	var nav    = document.querySelector( '.main-navigation' );

	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			var open = nav.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	}

	// Smooth scroll for in-page anchors.
	document.querySelectorAll( 'a[href^="#"]' ).forEach( function ( link ) {
		link.addEventListener( 'click', function ( event ) {
			var id = link.getAttribute( 'href' );
			if ( ! id || id.length < 2 ) {
				return;
			}
			var target = document.querySelector( id );
			if ( target ) {
				event.preventDefault();
				target.scrollIntoView( { behavior: 'smooth', block: 'start' } );
			}
		} );
	} );
} )();
