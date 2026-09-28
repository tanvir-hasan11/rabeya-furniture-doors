( function () {
	'use strict';

	var cfg = window.rabeyaPremium || {};
	var labels = cfg.labels || {};
	var KEY = 'rabeya_wishlist_v1';

	/* -----------------------------------------------------------------
	 * Helpers
	 * -------------------------------------------------------------- */
	function toast( message ) {
		var box = document.querySelector( '.premium-toast' );
		if ( ! box ) { return; }
		box.textContent = message;
		box.classList.add( 'is-visible' );
		window.clearTimeout( box._t );
		box._t = window.setTimeout( function () {
			box.classList.remove( 'is-visible' );
		}, 2200 );
	}

	function ajax( url, params ) {
		var query = new URLSearchParams( params ).toString();
		return fetch( url + '?' + query, { credentials: 'same-origin' } ).then( function ( r ) {
			return r.json();
		} );
	}

	/* -----------------------------------------------------------------
	 * Wishlist
	 * -------------------------------------------------------------- */
	function readList() {
		try {
			var raw = window.localStorage.getItem( KEY );
			return raw ? JSON.parse( raw ) : [];
		} catch ( e ) {
			return [];
		}
	}

	function writeList( list ) {
		try {
			window.localStorage.setItem( KEY, JSON.stringify( list ) );
		} catch ( e ) {}
		syncUI();
	}

	function syncUI() {
		var list = readList();

		document.querySelectorAll( '.wishlist-toggle' ).forEach( function ( btn ) {
			var id = String( btn.getAttribute( 'data-product-id' ) );
			var active = list.indexOf( id ) !== -1;
			btn.classList.toggle( 'is-active', active );
			btn.setAttribute( 'aria-pressed', active ? 'true' : 'false' );
		} );

		document.querySelectorAll( '.wishlist-count' ).forEach( function ( el ) {
			el.textContent = list.length;
		} );

		var drawer = document.querySelector( '.wish-drawer' );
		if ( drawer && drawer.classList.contains( 'is-open' ) ) {
			loadDrawer();
		}
	}

	function loadDrawer() {
		var body = document.getElementById( 'wishDrawerBody' );
		var list = readList();

		if ( ! body ) { return; }

		if ( ! list.length ) {
			body.innerHTML = '<p class="wish-empty">' + ( labels.empty || 'Empty' ) + '</p>';
			return;
		}

		body.innerHTML = '<p class="wish-loading">' + ( labels.loading || '' ) + '</p>';

		ajax( cfg.ajaxUrl, { action: 'rabeya_wishlist_items', ids: list.join( ',' ), nonce: cfg.nonce } ).then( function ( res ) {
			if ( res && res.success && res.data && res.data.html ) {
				body.innerHTML = res.data.html;
				syncUI();
			} else {
				body.innerHTML = '<p class="wish-empty">' + ( labels.empty || '' ) + '</p>';
			}
		} ).catch( function () {
			body.innerHTML = '<p class="wish-empty">' + ( labels.error || '' ) + '</p>';
		} );
	}

	document.addEventListener( 'click', function ( event ) {
		var btn = event.target.closest( '.wishlist-toggle' );

		if ( ! btn ) { return; }

		event.preventDefault();

		var id = String( btn.getAttribute( 'data-product-id' ) );
		var list = readList();
		var index = list.indexOf( id );

		if ( index === -1 ) {
			list.push( id );
			toast( labels.added || 'Added' );
		} else {
			list.splice( index, 1 );
			toast( labels.removed || 'Removed' );
		}

		writeList( list );
	} );

	/* Drawer open / close */
	var drawerBtn = document.querySelector( '.float-wishlist' );
	var drawer = document.querySelector( '.wish-drawer' );
	var drawerClose = document.querySelector( '.wish-drawer-close' );

	function openDrawer() {
		if ( ! drawer ) { return; }
		drawer.classList.add( 'is-open' );
		drawer.setAttribute( 'aria-hidden', 'false' );
		loadDrawer();
	}

	function closeDrawer() {
		if ( ! drawer ) { return; }
		drawer.classList.remove( 'is-open' );
		drawer.setAttribute( 'aria-hidden', 'true' );
	}

	if ( drawerBtn ) { drawerBtn.addEventListener( 'click', openDrawer ); }
	if ( drawerClose ) { drawerClose.addEventListener( 'click', closeDrawer ); }

	/* -----------------------------------------------------------------
	 * Quick view
	 * -------------------------------------------------------------- */
	var qv = document.querySelector( '.quick-view' );
	var qvContent = qv ? qv.querySelector( '.qv-content' ) : null;

	function openQuickView( id ) {
		if ( ! qv || ! qvContent ) { return; }

		qv.classList.add( 'is-open' );
		qv.setAttribute( 'aria-hidden', 'false' );
		qvContent.innerHTML = '<p class="qv-loading">' + ( labels.loading || '' ) + '</p>';

		ajax( cfg.ajaxUrl, { action: 'rabeya_quick_view', product_id: id, nonce: cfg.nonce } ).then( function ( res ) {
			if ( res && res.success && res.data && res.data.html ) {
				qvContent.innerHTML = res.data.html;
				syncUI();
				if ( window.jQuery ) {
					window.jQuery( document.body ).trigger( 'wc_variation_form' );
				}
			} else {
				qvContent.innerHTML = '<p class="qv-loading">' + ( labels.error || '' ) + '</p>';
			}
		} ).catch( function () {
			qvContent.innerHTML = '<p class="qv-loading">' + ( labels.error || '' ) + '</p>';
		} );
	}

	function closeQuickView() {
		if ( ! qv ) { return; }
		qv.classList.remove( 'is-open' );
		qv.setAttribute( 'aria-hidden', 'true' );
	}

	document.addEventListener( 'click', function ( event ) {
		var btn = event.target.closest( '.quick-view-btn' );
		if ( btn ) {
			event.preventDefault();
			openQuickView( btn.getAttribute( 'data-product-id' ) );
			return;
		}

		if ( qv && ( event.target.closest( '.qv-close' ) || event.target.closest( '.qv-backdrop' ) ) ) {
			closeQuickView();
		}
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key === 'Escape' ) {
			closeQuickView();
			closeDrawer();
		}
	} );

	/* -----------------------------------------------------------------
	 * Back to top + scroll progress
	 * -------------------------------------------------------------- */
	var topBtn = document.querySelector( '.float-top' );
	var progress = document.querySelector( '.scroll-progress span' );

	function onScroll() {
		var scrolled = window.pageYOffset || document.documentElement.scrollTop;
		var height = document.documentElement.scrollHeight - window.innerHeight;

		if ( topBtn ) {
			topBtn.classList.toggle( 'is-visible', scrolled > 500 );
		}

		if ( progress && height > 0 ) {
			progress.style.width = ( ( scrolled / height ) * 100 ) + '%';
		}

		var sticky = document.querySelector( '.sticky-cart' );
		if ( sticky ) {
			var form = document.querySelector( 'form.cart' );
			if ( form ) {
				var rect = form.getBoundingClientRect();
				sticky.classList.toggle( 'is-visible', rect.bottom < 0 );
			}
		}
	}

	window.addEventListener( 'scroll', onScroll, { passive: true } );

	if ( topBtn ) {
		topBtn.addEventListener( 'click', function () {
			window.scrollTo( { top: 0, behavior: 'smooth' } );
		} );
	}

	/* -----------------------------------------------------------------
	 * Scroll reveal animations
	 * -------------------------------------------------------------- */
	function initReveal() {
		var targets = document.querySelectorAll(
			'.section, .home-notices, .trust, .shop-banner, .post-card, .category-card, .notice-card, .cta-inner'
		);

		if ( ! ( 'IntersectionObserver' in window ) ) {
			targets.forEach( function ( el ) { el.classList.add( 'is-visible' ); } );
			return;
		}

		var observer = new IntersectionObserver( function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-visible' );
					observer.unobserve( entry.target );
				}
			} );
		}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' } );

		targets.forEach( function ( el, i ) {
			el.classList.add( 'reveal' );
			el.style.transitionDelay = Math.min( i % 6, 5 ) * 60 + 'ms';
			observer.observe( el );
		} );
	}

	/* -----------------------------------------------------------------
	 * Boot
	 * -------------------------------------------------------------- */
	function boot() {
		syncUI();
		onScroll();
		initReveal();

		var stickyBtn = document.querySelector( '.sticky-cart-btn' );
		if ( stickyBtn ) {
			stickyBtn.addEventListener( 'click', function( event ) {
				event.preventDefault();
				var form = document.querySelector( 'form.cart' );
				if ( ! form ) { return; }
				var qtyInput = form.querySelector( 'input.qty' );
				if ( qtyInput && parseInt( qtyInput.value, 10 ) < 1 ) {
					qtyInput.value = 1;
				}
				var variationMissing = form.querySelector( '.woocommerce-variation-add-to-cart-disabled' );
				if ( variationMissing ) {
					toast( labels.error || 'Please select options first.' );
					return;
				}
				if ( window.jQuery ) {
					window.jQuery( form ).find( '[name="add-to-cart"]' ).trigger( 'click' );
				} else {
					var atcBtn = form.querySelector( '[type="submit"]' );
					if ( atcBtn ) { atcBtn.click(); }
				}
			} );
		}

		if ( window.jQuery ) {
			window.jQuery( document.body ).on( 'updated_wc_div updated_cart_totals wc_fragments_refreshed', syncUI );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', boot );
	} else {
		boot();
	}
} )();
