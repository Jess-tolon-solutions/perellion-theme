/**
 * Perellion motion. Included-tier scroll behavior only.
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

	/* ---- 0. Dropdown band (layout, not motion; runs for everyone) -------
	 * The frame's open dropdown is a white band from the left edge of the
	 * window to the right. The panel itself sits under its parent link, so
	 * the band is drawn from the panel and needs the panel's distance from
	 * the window edge, which only the page knows. */
	function placeDropdownBands() {
		var w = document.documentElement.clientWidth;
		document.querySelectorAll( '.perellion-header .wp-block-navigation .has-child' ).forEach( function ( li ) {
			var sub = li.querySelector( '.wp-block-navigation__submenu-container' );
			if ( ! sub ) { return; }
			var left = li.getBoundingClientRect().left - 32; // panel sits at left:-32px
			sub.style.setProperty( '--perellion-band-x', ( -left ) + 'px' );
			sub.style.setProperty( '--perellion-band-w', w + 'px' );
		} );
		document.documentElement.classList.add( 'perellion-bands' );
	}
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', placeDropdownBands );
	} else {
		placeDropdownBands();
	}
	window.addEventListener( 'resize', placeDropdownBands );

	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' );
	if ( reduce.matches ) {
		document.documentElement.classList.add( 'perellion-no-motion' );
		return;
	}

	document.documentElement.classList.add( 'perellion-motion' );

	/* ---- 1. Reveal on scroll ------------------------------------------ */

	var revealTargets = document.querySelectorAll( '.perellion-reveal' );

	/**
	 * Reveal anything at or above the fold that the observer has not
	 * caught. A fast scroll, a jump link or an anchored page load can
	 * skip an element entirely, and because the observer unobserves on
	 * first intersection those sections would stay invisible for good.
	 */
	function sweepReveals() {
		var vh = window.innerHeight || 0;
		var pending = document.querySelectorAll( '.perellion-reveal:not(.is-revealed)' );
		for ( var i = 0; i < pending.length; i++ ) {
			if ( pending[ i ].getBoundingClientRect().top < vh * 0.9 ) {
				pending[ i ].classList.add( 'is-revealed' );
			}
		}
	}

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
		heading.classList.add( 'perellion-lines' );
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

	/* ---- 6. Pinned scroll storytelling -------------------------------- */

	/**
	 * Handoff note 41:15480, 10.19.26:
	 *   "Sticky scroll storytelling on body copy: a 'Visual' section stays
	 *    pinned while words on the other side of the component scroll up
	 *    until the content is finished."
	 *   "Parallax depth layers on 'Visual' area: foreground and background
	 *    move at different speeds for the quote, image and brand elements.
	 *    Very subtle."
	 *
	 * The pin is applied from script rather than from a class in the
	 * pattern markup. Patterns are copied into a page at insert time, so a
	 * class added to a pattern today would not reach a page that was built
	 * yesterday. Detecting the shape at runtime means existing pages get
	 * the behavior without being rebuilt.
	 */

	var MIN_PIN_WIDTH = 861;   // below this the split collapses to one column
	var MIN_TRAVEL    = 120;   // px of overhang needed before pinning is worth it
	var HOLD          = 900;   // px of scrolling the pair stays held
	var WINDOW_PAD    = 16;    // the copy window sits this much taller than the photo
	var MIN_WINDOW    = 0.15;  // safety net: below this share of the copy, do not pin
	var FADE_TOP      = 52;    // depth of the top fade band
	var FADE_BOTTOM   = 96;    // depth of the bottom fade band, plus clearance

	var splits = Array.prototype.slice.call( document.querySelectorAll( '.perellion-split' ) )
		.map( function ( split ) {
			return {
				el:    split,
				panel: split.querySelector( ':scope > .perellion-panel' ),
				text:  split.querySelector( ':scope > .perellion-split__text' )
			};
		} )
		.filter( function ( s ) {
			return s.panel && s.text;
		} );

	var siteHeader = document.querySelector( '.wp-block-template-part header, header.wp-block-template-part, .perellion-header' );

	/**
	 * Give each half a column wrapper and put the copy inside a window.
	 *
	 * Both halves have to be held while only the words move, which means the
	 * sticky elements need a taller box to travel inside. That box does not
	 * exist in the pattern markup, and adding it to the pattern would not
	 * reach a page that was built before today, so it is assembled here.
	 */
	function buildWindows() {
		splits.forEach( function ( s ) {
			if ( s.built ) {
				return;
			}

			var textCol = document.createElement( 'div' );
			textCol.className = 'perellion-col perellion-col--text';
			s.el.insertBefore( textCol, s.text );
			textCol.appendChild( s.text );

			var mediaCol = document.createElement( 'div' );
			mediaCol.className = 'perellion-col perellion-col--media';
			s.el.insertBefore( mediaCol, s.panel );
			mediaCol.appendChild( s.panel );

			var inner = document.createElement( 'div' );
			inner.className = 'perellion-copy__inner';
			while ( s.text.firstChild ) {
				inner.appendChild( s.text.firstChild );
			}
			s.text.appendChild( inner );

			s.textCol  = textCol;
			s.mediaCol = mediaCol;
			s.inner    = inner;
			s.built    = true;
		} );
	}

	/**
	 * Decide which splits pin, size the window against the photograph, and
	 * give both columns the height that sets how long the pair is held.
	 * Runs on load and on resize, never per frame: it reads layout and would
	 * thrash the scroll loop.
	 */
	function measurePins() {
		var vh = window.innerHeight || 0;
		var headerH = siteHeader ? siteHeader.offsetHeight : 0;

		// The section nav docks under the header as a fixed bar on every
		// scroll position where a split can be pinned, so it is part of the
		// chrome the copy has to clear. Without it the first line of a
		// pinned column sat under the bar (Jess, 20 Nov, Adv Mfg).
		var dockedBar = document.querySelector( '.perellion-anchorbar' );
		if ( dockedBar ) {
			headerH += dockedBar.offsetHeight;
		}

		// Published so the stylesheet can size the pinned panel to the
		// space below the header. Measured here because this already runs
		// on load and resize, which is exactly when the value can change.
		document.documentElement.style.setProperty( '--perellion-header-h', headerH + 'px' );

		splits.forEach( function ( s ) {
			s.el.classList.remove( 'is-pinned' );
			s.textCol.style.height = '';
			s.mediaCol.style.height = '';
			s.text.style.height = '';
			s.inner.style.transform = '';

			if ( window.innerWidth < MIN_PIN_WIDTH ) {
				return;
			}

			var panelH = s.panel.offsetHeight;
			var img    = s.panel.querySelector( 'img' );

			// The window is measured against the circular photograph rather
			// than the panel box, because the panel box includes the
			// decorative bleed and is much taller than the circle the reader
			// actually sees.
			// The guard is on the HEIGHT, not on the element. An <img> that
			// exists but has not been laid out yet measures 0, and the old
			// `img ? ... : ...` test treated that as a real measurement, so
			// the window came out 16px tall on a section with 778px of copy
			// -- about 2% of it visible at a time. That is what was reported
			// on MedTech's Overview as "almost completely invisible". The
			// panel-proportion fallback is the right answer in that case.
			var photoH = ( img && img.offsetHeight ) ? img.offsetHeight
			                                         : Math.round( panelH * 0.65 );
			var winH   = photoH + WINDOW_PAD;

			// Nothing worth holding if the copy already fits the window.
			if ( s.inner.offsetHeight - winH < MIN_TRAVEL ) {
				return;
			}

			// Safety net only. With the zero-height case fixed above, a
			// window this small means something else has gone wrong with
			// measurement, and a static centered section is a better
			// failure than a sliver of scrolling copy. Deliberately well
			// below any legitimate ratio: an earlier attempt at 0.45 also
			// caught healthy sections and switched pinning off entirely at
			// ordinary laptop heights.
			if ( winH / s.inner.offsetHeight < MIN_WINDOW ) {
				return;
			}

			var colH = panelH + HOLD;

			s.text.style.height     = winH + 'px';
			s.textCol.style.height  = colH + 'px';
			s.mediaCol.style.height = colH + 'px';

			// Rest the panel near the middle of the viewport, never tucked
			// under the sticky header, and center the window on the circle.
			//
			// The clamp is restored. Removing it to force true centering
			// looked right in the code and was wrong in practice: the panel
			// is 700px and an ordinary laptop viewport is ~715px, so the
			// centered position never cleared the header and pinning
			// switched off on every section. If the top-anchoring this
			// clamp produces on short viewports is itself the alignment
			// complaint, the fix belongs in the panel's height, not here.
			var panelTop = Math.max( ( vh - panelH ) / 2, headerH + 24 );
			var winTop   = panelTop + ( panelH - winH ) / 2;

			s.el.style.setProperty( '--perellion-pin-top', Math.round( panelTop ) + 'px' );
			s.el.style.setProperty( '--perellion-win-top', Math.round( winTop ) + 'px' );

			s.span = Math.max( 1, colH - winH );
			s.top  = winTop;

			// The class has to go on BEFORE the copy is measured. The fade
			// clearance padding is scoped to .is-pinned, so measuring first
			// reads a block that is ~230px shorter than it will actually be,
			// and the copy then stops that far short of its last line.
			s.el.classList.add( 'is-pinned' );

			// Travel is matched to how long the window is genuinely stuck, so
			// the copy reaches its last line exactly as the pin releases
			// rather than finishing early and sitting dead.
			s.slide = Math.max( 0, s.inner.offsetHeight - winH );
		} );
	}

	/**
	 * Move the copy inside its window. The visual is left completely alone:
	 * any drift on it, however small, reads as the whole section scrolling
	 * and the pin stops being legible.
	 */
	function updatePins() {
		splits.forEach( function ( s ) {
			if ( ! s.built || ! s.el.classList.contains( 'is-pinned' ) ) {
				return;
			}
			var travelled = s.top - s.textCol.getBoundingClientRect().top;
			var p = Math.min( Math.max( travelled / s.span, 0 ), 1 );
			s.inner.style.transform = 'translate3d(0,' + ( -p * s.slide ).toFixed( 1 ) + 'px,0)';
		} );
	}

	/**
	 * The handoff note also asks for parallax depth inside the Visual area,
	 * with the artwork and the photograph drifting at different speeds. It
	 * is deliberately not applied while a panel is pinned: the two cancel
	 * each other out. Any movement on the held visual, even a dozen pixels,
	 * makes the eye read the whole section as scrolling, and the pin stops
	 * being legible at all. Reviewed with Sovo Oct 29; if the depth is
	 * wanted back, it belongs on the section's entry, before the pin takes
	 * hold, rather than during it.
	 */

	function onFrame() {
		/* Cleared first, not last. A browser does not run requestAnimationFrame
		 * callbacks in a hidden tab, so a page opened in a background tab
		 * schedules one frame that never arrives. With the flag cleared at the
		 * end, it stayed true forever and every later scroll returned early:
		 * reveals, parallax, pinning and the scroll cue were dead for the life
		 * of that page, and stayed dead after the tab was brought forward.
		 * Clearing on entry also means a throw below cannot wedge the loop. */
		ticking = false;

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
		// Panels are excluded: a panel is the element that pins, and it must
		// stay perfectly still for the pin to read.
		parallaxEls.forEach( function ( el ) {
			if ( el.classList.contains( 'perellion-panel' ) ) {
				return;
			}
			var rect = el.getBoundingClientRect();
			if ( rect.bottom < -200 || rect.top > vh + 200 ) {
				return;
			}
			var center = rect.top + rect.height / 2;
			var offset = ( center - vh / 2 ) / vh;
			var depth = parseFloat( el.dataset.perellionDepth || '18' );
			el.style.transform = 'translate3d(0,' + ( offset * depth * -1 ).toFixed( 2 ) + 'px,0)';
		} );

		updatePins();
		updateAnchorBar();
		sweepReveals();
	}

	function onScroll() {
		if ( ticking ) {
			return;
		}
		ticking = true;
		window.requestAnimationFrame( onFrame );
	}

	/* A tab scrolled while hidden has dropped every frame it asked for, so
	 * the page can be well down the document with nothing measured. Re-arm
	 * and catch up the moment it becomes visible. */
	document.addEventListener( 'visibilitychange', function () {
		if ( ! document.hidden ) {
			ticking = false;
			onScroll();
		}
	} );

	var resizeTimer = null;

	function remeasure() {
		buildWindows();
		measurePins();
		measureAnchorBar();
		buildClamps();
		onFrame();
	}

	window.addEventListener( 'scroll', onScroll, { passive: true } );
	window.addEventListener( 'resize', function () {
		onScroll();
		window.clearTimeout( resizeTimer );
		resizeTimer = window.setTimeout( remeasure, 150 );
	} );

	// Measure once the images that set the panel heights have loaded,
	// otherwise offsetHeight is read before the photos have any size.
	window.addEventListener( 'load', function () {
		sweepReveals();
		remeasure();
	} );

	if ( document.fonts && document.fonts.ready ) {
		document.fonts.ready.then( remeasure );
	}

	/* ---- 8. Mobile copy, shortened with a More... control -------------- */

	/**
	 * Feedback item 09, 29 Oct: "Match the centered section headings,
	 * wider text measure and shortened copy with the visible 'More...'
	 * treatment where shown in the original. R1 displays long full-copy
	 * blocks instead."
	 *
	 * The copy itself is not cut. It is collapsed to a readable opening
	 * and the rest is one tap away, so nothing is lost for a reader who
	 * wants it or for search engines.
	 */

	var CLAMP_WIDTH = 600;

	var clampTargets = Array.prototype.slice.call(
		document.querySelectorAll( '.perellion-split__text, .perellion-intro' )
	);

	function buildClamps() {
		var mobile = window.innerWidth <= CLAMP_WIDTH;

		clampTargets.forEach( function ( el ) {
			var body = el.querySelector( '.perellion-copy__inner' ) || el;
			var btn  = el.querySelector( '.perellion-more' );

			if ( ! mobile ) {
				el.classList.remove( 'perellion-clamp', 'is-clamped' );
				if ( btn ) {
					btn.remove();
				}
				return;
			}

			el.classList.add( 'perellion-clamp' );

			if ( ! btn ) {
				btn = document.createElement( 'button' );
				btn.type = 'button';
				btn.className = 'perellion-more';
				btn.setAttribute( 'aria-expanded', 'false' );
				btn.textContent = 'More...';
				btn.addEventListener( 'click', function () {
					var open = el.classList.toggle( 'is-clamped' ) === false;
					btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
					btn.textContent = open ? 'Less' : 'More...';
				} );
				el.appendChild( btn );
			}

			// Only worth collapsing if there is meaningfully more to read.
			var overflowing = body.scrollHeight > 420;
			btn.hidden = ! overflowing;
			el.classList.toggle( 'is-clamped', overflowing );
		} );
	}

	/* ---- 7. FAQ, open by default -------------------------------------- */

	/**
	 * Feedback item 10, 29 Oct: the frame shows the answers already
	 * visible in two columns, not a collapsed accordion. The markup is
	 * details/summary and is baked into the page, so the panels are
	 * opened here rather than by rebuilding it. Left as real details
	 * elements so the markup stays valid and a visitor can still close
	 * one if they want.
	 */
	document.querySelectorAll( '#faq details' ).forEach( function ( d ) {
		d.open = true;
	} );

	/* ---- 5. Smooth jump links ---------------------------------------- */

	document.querySelectorAll( '.perellion-sectionnav a[href^="#"]' ).forEach( function ( link ) {
		link.addEventListener( 'click', function ( e ) {
			var target = document.getElementById( link.getAttribute( 'href' ).slice( 1 ) );
			if ( ! target ) {
				return;
			}
			e.preventDefault();
			target.classList.add( 'is-revealed' );
			sweepReveals();
			target.scrollIntoView( { behavior: 'smooth', block: 'start' } );
		} );
	} );

	/* ---- 9. Industry Challenges infographic, one asset per breakpoint -
	 * Haley supplied the six industries at three tiers on 2 Nov: xs is
	 * portrait, 340x1210, the vertical stack of circles she asked for on
	 * mobile; m and xl are landscape at 9:5. Because the orientation
	 * changes between tiers this cannot be a srcset, which assumes one
	 * image at several resolutions. It needs a picture element, so the
	 * browser picks the right drawing rather than the right size of the
	 * same drawing.
	 *
	 * The img is baked into each page's content at insert time, so it is
	 * rewritten here rather than in the pattern. That way the existing
	 * Defense page picks this up from a theme upload alone.
	 * ------------------------------------------------------------------ */

	/**
	 * The filename stem for each industry, keyed by a fragment that
	 * appears in its page path. Haley renamed three of the six between
	 * the October and November exports, so these are the new stems.
	 */
	var INFOGRAPHIC_STEMS = {
		defense: 'perellion-defense-manufacturing-challenges-infographic',
		aerospace: 'perellion-aerospace-manufacturing-challenges-infographic',
		space: 'perellion-space-manufacturing-challenges-infographic',
		medtech: 'perellion-medtech-medical-device-manufacturing-challenges-infographic',
		medical: 'perellion-medtech-medical-device-manufacturing-challenges-infographic',
		energy: 'perellion-energy-ev-battery-manufacturing-challenges-infographic',
		advanced: 'perellion-advanced-manufacturing-automation-challenges-infographic'
	};

	/**
	 * Where the theme lives. Taken from a file the theme is known to
	 * have loaded rather than hard-coded, so this survives the site
	 * moving between dev and production, and does not care whether the
	 * baked-in img pointed at the theme or at the media library.
	 */
	function themeBase() {
		/* This file only exists in the child theme, so its own src is the
		 * one unambiguous answer. The stylesheet lookup that used to come
		 * first matched Ollie's style.css, because the parent sheet is
		 * enqueued ahead of the child's, and every infographic URL came
		 * out as /themes/ollie/... and 404'd. */
		var script = document.currentScript ||
			document.querySelector( 'script[src*="/assets/js/motion.js"]' );
		if ( script && script.src ) {
			return script.src.replace( /assets\/js\/motion\.js.*$/, '' );
		}

		/* Fall back to a stylesheet, but only one that is not the parent. */
		var links = document.querySelectorAll( 'link[rel="stylesheet"][href*="/style.css"]' );
		for ( var i = 0; i < links.length; i++ ) {
			if ( links[ i ].href.indexOf( '/themes/ollie/' ) === -1 ) {
				return links[ i ].href.replace( /style\.css.*$/, '' );
			}
		}
		return '';
	}

	( function swapInfographic() {
		var figure = document.querySelector( '#challenges .perellion-infographic' );
		if ( ! figure ) {
			return;
		}

		var img = figure.querySelector( 'img' );
		if ( ! img || figure.querySelector( 'picture' ) ) {
			return;
		}

		/* An explicit data-infographic on the figure wins, so a page whose
		 * URL does not carry its industry can still be pointed at one by
		 * hand in the editor. */
		var stem = figure.dataset.infographic
			? 'perellion-' + figure.dataset.infographic + '-challenges-infographic'
			: null;

		if ( ! stem ) {
			var path = window.location.pathname.toLowerCase();
			Object.keys( INFOGRAPHIC_STEMS ).some( function ( key ) {
				if ( path.indexOf( key ) !== -1 ) {
					stem = INFOGRAPHIC_STEMS[ key ];
					return true;
				}
				return false;
			} );
		}

		/* No match means an industry page this build does not know about.
		 * Leaving the baked-in image alone is the right failure: the
		 * section still renders, just without the new asset. */
		if ( ! stem ) {
			return;
		}

		/* The directory comes from the src the generator baked into the
		 * page, not from the theme. The infographics moved into the media
		 * library on 11 Nov because 5.3MB of them inside the theme was
		 * breaking the installer, and deriving the directory this way
		 * means this file holds no uploads path of its own: if the assets
		 * ever move again, regenerating the pages is the only change.
		 * A page still carrying a pre-11-Nov theme src will point this at
		 * the theme and 404, so all six pages must be regenerated
		 * alongside this. */
		var dir = img.src.replace( /[^\/]+$/, '' );

		/* 21 Nov: a src that already names a tier (…-xs-1x.jpg) carries its
		 * own directory and stem, wherever it lives. Sovo's 14 Nov typo-fixed
		 * Aerospace set ships inside the theme under assets/img/infographics
		 * this way. */
		var tiered = img.src.match( /^(.*\/)([^\/]+)-(xl|m|xs)-(1x|2x)\.jpg$/ );
		if ( tiered ) {
			dir = tiered[ 1 ];
			stem = tiered[ 2 ];
		}

		/* The Defense page predates the generator: its markup was copied
		 * from patterns/section-challenges.php at insert time and still
		 * carries the single theme-hosted PNG, because a pattern change
		 * never retrofits a page already built from it. Deriving dir from
		 * that src would point every tier at the theme, where the tiers no
		 * longer live, and 404 all three. So a theme-hosted src opts out:
		 * Defense keeps the one PNG it renders today, which is correct,
		 * just not responsive. Repointing that page's img at
		 * /wp-content/uploads/2026/11/...-xs-1x.jpg is all it needs to
		 * join the other five, and then defense-challenges-infographic.png
		 * can come out of the theme too. Held until the R2 freeze lifts. */
		if ( ! tiered && dir.indexOf( '/themes/' ) !== -1 ) {
			return;
		}

		function pair( size ) {
			return dir + stem + '-' + size + '-1x.jpg 1x, ' +
			       dir + stem + '-' + size + '-2x.jpg 2x';
		}

		var picture = document.createElement( 'picture' );

		/* Ordered widest first: the browser takes the first source whose
		 * media query matches, so a descending list reads as xl, then m,
		 * then the img itself as the xs case. */
		[
			{ media: '(min-width: 1025px)', size: 'xl' },
			{ media: '(min-width: 601px)', size: 'm' }
		].forEach( function ( tier ) {
			var source = document.createElement( 'source' );
			source.media = tier.media;
			source.srcset = pair( tier.size );
			source.type = 'image/jpeg';
			picture.appendChild( source );
		} );

		/* The img carries the xs pair and stays the element the CSS and
		 * the alt text hang off. Width and height attributes from the old
		 * markup describe the old file, so they go; the CSS caps each
		 * tier instead. */
		img.removeAttribute( 'width' );
		img.removeAttribute( 'height' );
		img.srcset = pair( 'xs' );
		img.src = dir + stem + '-xs-1x.jpg';
		img.decoding = 'async';

		img.parentNode.insertBefore( picture, img );
		picture.appendChild( img );
		figure.classList.add( 'is-responsive' );
	} )();

	/* ---- 9. Docked anchor bar with scroll-spy -------------------------
	 * Feedback item [02]: "Please add in the animation from the Figma file
	 * see demo here."
	 *
	 * The demo is not a prototype; the file has no keyframe animation and
	 * no flows at all. It is four static frames on the Demos page
	 * (247:12966, desktop 1440, tablet 768, mobile 390) plus two frames
	 * named "Scroll behavior" (21:23347, 21:29434) showing the Defense
	 * page mid-scroll: the header condensed, this bar docked beneath it,
	 * and CHALLENGES lit in blue.
	 *
	 * A fixed clone, not the hero's own nav promoted to sticky. Sticky is
	 * confined to its parent's box and that nav lives inside a group that
	 * ends with the hero, so it could never travel. The clone also avoids
	 * the layout jump that promoting the original would cause. Both copies
	 * carry the highlight so they cannot disagree while both are visible.
	 * ------------------------------------------------------------------ */

	var anchorBar = null;
	var anchorBarLinks = [];
	var heroNavLinks = [];
	var anchorTargets = [];
	var anchorDockAt = 0;

	function headerHeight() {
		var header = document.querySelector(
			'.wp-site-blocks > header, header.wp-block-template-part'
		);
		return header ? header.offsetHeight : 0;
	}

	function buildAnchorBar() {
		if ( ! sectionNav ) {
			return;
		}
		heroNavLinks = Array.prototype.slice.call(
			sectionNav.querySelectorAll( 'a[href^="#"]' )
		);
		if ( ! heroNavLinks.length ) {
			return;
		}

		/* A link whose target is absent is kept in the bar but never
		 * highlighted. Five of the six pages ship a nav link for a
		 * section their frame does not have, so this is the normal case
		 * rather than an error. */
		anchorTargets = heroNavLinks.map( function ( a ) {
			return document.getElementById( a.getAttribute( 'href' ).slice( 1 ) );
		} );

		anchorBar = document.createElement( 'nav' );
		anchorBar.className = 'perellion-anchorbar';
		anchorBar.setAttribute( 'aria-label', 'Sections on this page' );

		heroNavLinks.forEach( function ( a ) {
			var clone = document.createElement( 'a' );
			clone.href = a.getAttribute( 'href' );
			clone.textContent = ( a.textContent || '' ).trim();
			anchorBar.appendChild( clone );
		} );

		document.body.appendChild( anchorBar );
		anchorBarLinks = Array.prototype.slice.call(
			anchorBar.querySelectorAll( 'a' )
		);

		measureAnchorBar();
	}

	function measureAnchorBar() {
		if ( ! anchorBar || ! sectionNav ) {
			return;
		}
		var h = headerHeight();
		/* The header is sticky, so its on-screen bottom is where the bar
		 * docks; that also absorbs the admin bar for logged-in reviewers. */
		var hdr = document.querySelector( '.wp-site-blocks > header, header.wp-block-template-part' );
		var dockTop = hdr ? Math.max( 0, Math.round( hdr.getBoundingClientRect().bottom ) ) : h;
		anchorBar.style.top = dockTop + 'px';

		/* Dock the moment the hero's own copy has cleared the header, so
		 * the two are never both in the same place on screen. */
		var rect = sectionNav.getBoundingClientRect();
		anchorDockAt = rect.top + ( window.pageYOffset ||
			document.documentElement.scrollTop ) + rect.height - h;
	}

	function setCurrentAnchor( index ) {
		[ anchorBarLinks, heroNavLinks ].forEach( function ( set ) {
			set.forEach( function ( a, i ) {
				var on = i === index;
				if ( a.classList.contains( 'is-current' ) !== on ) {
					a.classList.toggle( 'is-current', on );
				}
				if ( on ) {
					a.setAttribute( 'aria-current', 'true' );
				} else {
					a.removeAttribute( 'aria-current' );
				}
			} );
		} );
	}

	function updateAnchorBar() {
		if ( ! anchorBar ) {
			return;
		}

		var y = window.pageYOffset || document.documentElement.scrollTop;
		var docked = y > anchorDockAt;
		if ( docked !== anchorBar.classList.contains( 'is-docked' ) ) {
			anchorBar.classList.toggle( 'is-docked', docked );
		}

		/* The in-view section is the last one whose top has passed under
		 * the bar. Measured against the bar's own underside so the
		 * highlight changes exactly when the heading goes behind it. */
		var line = headerHeight() + anchorBar.offsetHeight + 8;
		var current = -1;
		anchorTargets.forEach( function ( el, i ) {
			if ( el && el.getBoundingClientRect().top <= line ) {
				current = i;
			}
		} );
		setCurrentAnchor( current );
	}

	/* ---- First run ----------------------------------------------------
	 * Kept at the very bottom. These call into every section above, and
	 * the collections they read are declared with var, so running them
	 * earlier in the file would hand them an undefined list.
	 * ------------------------------------------------------------------ */

	/* ---- Card carousels (Meet the team on About) -----------------------
	 * The track is a native horizontal scroller; the buttons just nudge it
	 * by most of a viewport so keyboard and touch users lose nothing. */
	document.querySelectorAll( '[data-carousel]' ).forEach( function ( c ) {
		var vp = c.querySelector( '.perellion-carousel__viewport' );
		if ( ! vp ) { return; }
		var step = function ( dir ) {
			vp.scrollBy( { left: dir * Math.max( 300, vp.clientWidth * 0.8 ), behavior: 'smooth' } );
		};
		var prev = c.querySelector( '[data-carousel-prev]' );
		var next = c.querySelector( '[data-carousel-next]' );
		if ( prev ) { prev.addEventListener( 'click', function () { step( -1 ); } ); }
		if ( next ) { next.addEventListener( 'click', function () { step( 1 ); } ); }
	} );

	buildWindows();
	measurePins();
	buildAnchorBar();
	buildClamps();
	onFrame();
	sweepReveals();
} )();
