/**
 * Perellion motion. Included-tier scroll behaviour only.
 *
 * Covers: fade/rise on scroll, line-by-line headline reveal, section-nav
 * fade on scroll, scroll cue disappearing, background and depth parallax.
 *
 * Deliberately NOT here (change-order items in SOW section 5.5):
 * clip-path hero reveal, sticky scroll storytelling, card carousel.
 * Those layer on top of this file without rebuilding it.
 */
( function () {
	'use strict';

	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' );
	if ( reduce.matches ) {
		document.documentElement.classList.add( 'perellion-no-motion' );
		return;
	}

	document.documentElement.classList.add( 'perellion-motion' );

	/* ---- 1. Reveal on scroll ------------------------------------------ */

	var revealTargets = document.querySelectorAll( '.perellion-reveal' );

	if ( 'IntersectionObserver' in window && revealTargets.length ) {
		var revealObserver = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					entry.target.classList.add( 'is-revealed' );
					revealObserver.unobserve( entry.target );
				} );
			},
			{ rootMargin: '0px 0px -12% 0px', threshold: 0.12 }
		);

		revealTargets.forEach( function ( el, i ) {
			// Stagger siblings inside a grid so cards arrive in sequence.
			if ( el.parentElement && el.parentElement.classList.contains( 'perellion-card-grid' ) ) {
				el.style.setProperty( '--perellion-reveal-delay', ( i % 6 ) * 70 + 'ms' );
			}
			revealObserver.observe( el );
		} );
	} else {
		revealTargets.forEach( function ( el ) {
			el.classList.add( 'is-revealed' );
		} );
	}

	/* ---- 2. Headline reveal, line by line ----------------------------- */

	function splitLines( heading ) {
		if ( heading.dataset.perellionSplit === 'done' ) {
			return;
		}

		var words = [];

		// Wrap every word, keeping inline markup (the gradient span) intact.
		function wrapWords( node ) {
			if ( node.nodeType === Node.TEXT_NODE ) {
				var frag = document.createDocumentFragment();
				node.textContent.split( /(\s+)/ ).forEach( function ( chunk ) {
					if ( chunk === '' ) {
						return;
					}
					if ( /^\s+$/.test( chunk ) ) {
						frag.appendChild( document.createTextNode( chunk ) );
						return;
					}
					var w = document.createElement( 'span' );
					w.className = 'perellion-word';
					w.textContent = chunk;
					words.push( w );
					frag.appendChild( w );
				} );
				node.parentNode.replaceChild( frag, node );
				return;
			}
			Array.prototype.slice.call( node.childNodes ).forEach( wrapWords );
		}

		wrapWords( heading );

		// Group words into visual lines by their offsetTop.
		var lines = [];
		var currentTop = null;
		words.forEach( function ( w ) {
			var top = w.offsetTop;
			if ( currentTop === null || Math.abs( top - currentTop ) > 4 ) {
				lines.push( [] );
				currentTop = top;
			}
			lines[ lines.length - 1 ].push( w );
		} );

		lines.forEach( function ( line, i ) {
			line.forEach( function ( w ) {
				w.style.setProperty( '--perellion-line-delay', i * 110 + 'ms' );
			} );
		} );

		heading.dataset.perellionSplit = 'done';
		heading.classList.add( 'perellion-split' );
	}

	var headlines = document.querySelectorAll( '.perellion-hero__title' );

	if ( 'IntersectionObserver' in window && headlines.length ) {
		var headlineObserver = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( ! entry.isIntersecting ) {
						return;
					}
					splitLines( entry.target );
					entry.target.classList.add( 'is-revealed' );
					headlineObserver.unobserve( entry.target );
				} );
			},
			{ threshold: 0.25 }
		);
		headlines.forEach( function ( h ) {
			headlineObserver.observe( h );
		} );
	}

	/* ---- 3 & 4. Section nav opacity, scroll cue ----------------------- */

	var sectionNav = document.querySelector( '.perellion-sectionnav' );
	var scrollCue = document.querySelector( '.perellion-scrollcue' );
	var parallaxEls = Array.prototype.slice.call( document.querySelectorAll( '.perellion-parallax' ) );
	var ticking = false;

	function onFrame() {
		var y = window.pageYOffset || document.documentElement.scrollTop;
		var vh = window.innerHeight || 1;

		// Jump links travel 80% to 100% opacity over the first viewport.
		if ( sectionNav ) {
			var p = Math.min( y / ( vh * 0.6 ), 1 );
			sectionNav.style.opacity = String( 0.8 + 0.2 * p );
		}

		// Scroll cue fades out as soon as the visitor starts scrolling.
		if ( scrollCue ) {
			var cueOpacity = Math.max( 1 - y / ( vh * 0.35 ), 0 );
			scrollCue.style.opacity = String( cueOpacity );
			scrollCue.style.visibility = cueOpacity < 0.02 ? 'hidden' : 'visible';
		}

		// Depth parallax: elements drift against the scroll direction.
		parallaxEls.forEach( function ( el ) {
			var rect = el.getBoundingClientRect();
			if ( rect.bottom < -200 || rect.top > vh + 200 ) {
				return;
			}
			var centre = rect.top + rect.height / 2;
			var offset = ( centre - vh / 2 ) / vh;
			var depth = parseFloat( el.dataset.perellionDepth || '18' );
			el.style.transform = 'translate3d(0,' + ( offset * depth * -1 ).toFixed( 2 ) + 'px,0)';
		} );

		ticking = false;
	}

	function onScroll() {
		if ( ticking ) {
			return;
		}
		ticking = true;
		window.requestAnimationFrame( onFrame );
	}

	window.addEventListener( 'scroll', onScroll, { passive: true } );
	window.addEventListener( 'resize', onScroll );
	onFrame();

	/* ---- 5. Smooth jump links ---------------------------------------- */

	document.querySelectorAll( '.perellion-sectionnav a[href^="#"]' ).forEach( function ( link ) {
		link.addEventListener( 'click', function ( e ) {
			var target = document.getElementById( link.getAttribute( 'href' ).slice( 1 ) );
			if ( ! target ) {
				return;
			}
			e.preventDefault();
			target.scrollIntoView( { behavior: 'smooth', block: 'start' } );
		} );
	} );
} )();
