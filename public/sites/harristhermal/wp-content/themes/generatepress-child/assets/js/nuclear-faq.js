/**
 * Nuclear landing page — FAQ accordion.
 *
 * Single-open accordion: opening one item closes the others. Scoped to the
 * landing page because the script is only enqueued on that template.
 */
( function () {
	'use strict';

	function initFaq() {
		var questions = document.querySelectorAll( '.ntl .faq-question' );
		if ( ! questions.length ) {
			return;
		}

		questions.forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var item = btn.closest( '.faq-item' );
				var isOpen = item.classList.contains( 'open' );

				// Close all open items.
				document.querySelectorAll( '.ntl .faq-item.open' ).forEach( function ( el ) {
					el.classList.remove( 'open' );
					el.querySelector( '.faq-question' ).setAttribute( 'aria-expanded', 'false' );
				} );

				// Open the clicked item if it was closed.
				if ( ! isOpen ) {
					item.classList.add( 'open' );
					btn.setAttribute( 'aria-expanded', 'true' );
				}
			} );
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initFaq );
	} else {
		initFaq();
	}
} )();
