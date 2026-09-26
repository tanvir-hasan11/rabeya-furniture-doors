( function () {
	'use strict';

	var strips = document.querySelectorAll( '.offer-strip[data-deadline]' );

	if ( ! strips.length ) {
		return;
	}

	function pad( n ) {
		return String( n ).padStart( 2, '0' );
	}

	strips.forEach( function ( strip ) {
		var raw = strip.getAttribute( 'data-deadline' );

		if ( ! raw ) {
			return;
		}

		var parts = raw.split( '-' );
		var end = new Date(
			parseInt( parts[0], 10 ),
			parseInt( parts[1], 10 ) - 1,
			parseInt( parts[2] || '1', 10 ),
			23, 59, 59
		);

		if ( isNaN( end.getTime() ) ) {
			return;
		}

		function update() {
			var diff = end.getTime() - Date.now();

			if ( diff <= 0 ) {
				strip.querySelectorAll( '.num' ).forEach( function ( el ) { el.textContent = '00'; } );
				return;
			}

			var sec = Math.floor( diff / 1000 );
			var days = Math.floor( sec / 86400 );
			var hours = Math.floor( ( sec % 86400 ) / 3600 );
			var mins = Math.floor( ( sec % 3600 ) / 60 );
			var secs = sec % 60;

			var map = { days: days, hours: hours, minutes: mins, seconds: secs };

			Object.keys( map ).forEach( function ( key ) {
				var el = strip.querySelector( '[data-unit="' + key + '"]' );
				if ( el ) {
					el.textContent = pad( map[ key ] );
				}
			} );
		}

		update();
		window.setInterval( update, 1000 );
	} );
} )();
