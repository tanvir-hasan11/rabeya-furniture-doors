( function () {
	'use strict';

	var slider = document.querySelector( '.hero-slider' );
	if ( ! slider ) {
		return;
	}

	var slides = slider.querySelectorAll( '.slide' );
	if ( slides.length < 2 ) {
		return;
	}

	var dots       = slider.querySelectorAll( '.slider-dot' );
	var current    = 0;
	var timer      = null;
	var INTERVAL   = 6000;

	function show( index ) {
		current = ( index + slides.length ) % slides.length;

		slides.forEach( function ( slide, i ) {
			slide.classList.toggle( 'is-active', i === current );
		} );

		dots.forEach( function ( dot, i ) {
			dot.classList.toggle( 'is-active', i === current );
			dot.setAttribute( 'aria-selected', i === current ? 'true' : 'false' );
		} );
	}

	function next() { show( current + 1 ); }
	function prev() { show( current - 1 ); }

	function start() {
		stop();
		timer = setInterval( next, INTERVAL );
	}

	function stop() {
		if ( timer ) {
			clearInterval( timer );
			timer = null;
		}
	}

	dots.forEach( function ( dot ) {
		dot.addEventListener( 'click', function () {
			show( parseInt( dot.getAttribute( 'data-index' ), 10 ) );
			start();
		} );
	} );

	var nextBtn = slider.querySelector( '.slider-next' );
	var prevBtn = slider.querySelector( '.slider-prev' );

	if ( nextBtn ) { nextBtn.addEventListener( 'click', function () { next(); start(); } ); }
	if ( prevBtn ) { prevBtn.addEventListener( 'click', function () { prev(); start(); } ); }

	slider.addEventListener( 'mouseenter', stop );
	slider.addEventListener( 'mouseleave', start );

	slider.addEventListener( 'keydown', function ( event ) {
		if ( 'ArrowRight' === event.key ) { next(); }
		if ( 'ArrowLeft' === event.key ) { prev(); }
	} );

	start();
} )();
