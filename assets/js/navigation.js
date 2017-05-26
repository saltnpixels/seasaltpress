/* global seasaltpressScreenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

(function( $ ) {
	var page, menuToggle, siteNavContain, siteNavigation, $body, $mobileMenuWidth, $sidebarWidth;
	
	$mobileMenuWidth = 600; //change to match your scss variable for mobile menu media query
	$sidebarWidth = 800; //change to match sidebar mobile width media query

	function initMainNavigation( container ) {
		
		
		

		// Add dropdown toggle that displays child menu items. Used on mobile and screenreaders.
		var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false })
			.append( seasaltpressScreenReaderText.icon )
			.append( $( '<span />', { 'class': 'screen-reader-text', text: seasaltpressScreenReaderText.expand }) );

		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).insert( dropdownToggle ); //removed insert() and added append()
		
		// Set the active submenu dropdown toggle button initial state.
		container.find( '.current-menu-ancestor > button, .current-menu-parent' )
			.addClass( 'toggled-on' )
			.attr( 'aria-expanded', 'true' )
			.find( '.screen-reader-text' )
			.text( seasaltpressScreenReaderText.collapse );
		// Set the active submenu initial state.
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' ).slideDown(); //added slidedown


		container.find( '.dropdown-toggle' ).click( function( e ) {
			var _this = $( this ),
				screenReaderSpan = _this.find( '.screen-reader-text' );

			e.preventDefault();
			_this.toggleClass( 'toggled-on' );
			_this.closest('li').toggleClass('toggled-on'); //added for styling the item clicked
			_this.closest('li').children( '.children, .sub-menu' ).toggleClass( 'toggled-on' ).slideToggle();

			_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

			screenReaderSpan.text( screenReaderSpan.text() === seasaltpressScreenReaderText.expand ? seasaltpressScreenReaderText.collapse : seasaltpressScreenReaderText.expand );
		});
	}

	initMainNavigation( $( '.main-navigation' ) );
	initMainNavigation( $( '.widget-area' ) ); //added for widgets
  
  //cool menu addition
	$body       = $( document.body );
	page       = $( '#page' );
	menuToggle     = page.find( '.menu-toggle' );
	siteNavContain = page.find( '.mobile-popout' );
	siteNavigation = page.find( '.main-navigation > div > ul' );
	

	// Enable menuToggle.
	(function() {

		// Return early if menuToggle is missing.
		if ( ! menuToggle.length ) {
			return;
		}

		// Add an initial value for the attribute.
		menuToggle.attr( 'aria-expanded', 'false' );

		//menu opens. click event
		
		menuToggle.on( 'click.seasaltpress', function() {
			siteNavContain.toggleClass( 'toggled-on' );
			menuToggle.attr( 'aria-expanded', siteNavContain.hasClass( 'toggled-on' ) ).toggleClass('toggled-on');
		
			
			
			//cool menu work takes over to make sure things are done in transition order
			if($body.hasClass('cool-menu')){
		
				toggleCoolMenu();	
			}
			else{
			
			
				$('.site-top').toggleClass('toggled-on');
				//regular menu, close menu if they click on the page
				if( menuToggle.hasClass('toggled-on') ){
					menuToggle.css('height', $('.site-top').height() );
					$('.site-content').one('click', function() {
							menuToggle.trigger('click'); //recursively calls togglecoolmenu
						});
				}
				else{
					menuToggle.css('height', '100%' );
				}
			}
			
		});
	})();
	

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	(function() {
		if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
			return;
		}

		// Toggle `focus` class to allow submenu access on tablets.
		function toggleFocusClassTouchScreen() {
			if ( 'none' === $( '.menu-toggle' ).css( 'display' ) ) {

				$( document.body ).on( 'touchstart.seasaltpress', function( e ) {
					if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
						$( '.main-navigation li' ).removeClass( 'focus' );
					}
				});

				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' )
					.on( 'touchstart.seasaltpress', function( e ) {
						var el = $( this ).parent( 'li' );

						if ( ! el.hasClass( 'focus' ) ) {
							e.preventDefault();
							el.toggleClass( 'focus' );
							el.siblings( '.focus' ).removeClass( 'focus' );
						}
					});

			} else {
				siteNavigation.find( '.menu-item-has-children > a, .page_item_has_children > a' ).unbind( 'touchstart.seasaltpress' );
			}
		}

		if ( 'ontouchstart' in window ) {
			$( window ).on( 'resize.seasaltpress', toggleFocusClassTouchScreen );
			toggleFocusClassTouchScreen();
		}

		siteNavigation.find( 'a' ).on( 'focus.seasaltpress blur.seasaltpress', function() {
			$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		});
	})();
	
	
	
	
	
	
/*--------------------------------------------------------------
# Cool Menu addition
--------------------------------------------------------------*/
	function toggleCoolMenu(){
		
		if( menuToggle.hasClass('toggled-on') ){
				$($body).addClass('menu-lock'); //somewhat locks on ios... can use return false if needed...
				
				//wrap the inner of #page and transition that with css. This way we dont have to animate #page, 
				//#page keeps overflow hidden so on ios you cant scroll all over. 
				page.wrapInner( "<div class='page-holder' />");
				
	
				//toggle the transitions and click action one AFTER the wrap is made
				setTimeout(function() {
					page.addClass('mobile-menu-open');
					siteNavContain.addClass( 'open' ); //shows the menu
			
						$('.page-holder').one('click', function(e) {
							
							if(! $(e.target).closest('.menu-toggle').length ){
								menuToggle.trigger('click'); //recursively calls togglecoolmenu
							}
						});
					
					//close menu if they click on the page holder
				}, 100);
				
				
				
				
		}
		//closing menu and unwrapping pageholder
		if(! menuToggle.hasClass('toggled-on')  ){
			page.removeClass('mobile-menu-open'); //closes menu by removing this class and putting page holder back in place.
    	$body.removeClass('menu-lock');
    			
    	$('.page-holder').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
	   			siteNavContain.removeClass( 'open' ); //only remove toggle and hide menu once page holder finishes its transition to cover it.
		 			$('.page-holder').children().unwrap('.page-holder');
   		});
		}
	}//end cool-menu
	
	
	
/*--------------------------------------------------------------
# Resize for cool menu and logo in middle of menu
--------------------------------------------------------------*/
	//this code runs on resize and move the cool menu into place. It also is responsible for a logo in middle of menu if thatw as chosen in customizer
	var mainNavigationLi = $('.main-navigation ul.menu>li, .main-navigation .menu>ul>li');
	
	function resizeMobileMenu(){

		if( $(window).width() < $mobileMenuWidth ){
			//if the body doesnt have the mobile popout already
			if( ! $('body>.mobile-popout').length && $body.hasClass('cool-menu') ){
				$(siteNavContain.prependTo($body));
			}
			
		//if middle logo, take it out and put it like it would be a left logo on mobile.
		if( $('.li-logo-holder').length ){
			$('.site-logo').prependTo('.site-top-inner-container');
			$('.li-logo-holder').remove();
		}
	
	}
		//else its desktop				
		else{
			
			if( $('body>.mobile-popout').length && $body.hasClass('cool-menu') ){
				$(siteNavContain.appendTo('.site-top-inner-container') );
				//close menu and unwrap page
					if( menuToggle.hasClass('toggled-on') ){
						$('.page-holder').trigger('click'); //turns this off and closes everything in one fell swoop
						siteNavContain.toggleClass( 'open' ); //only remove toggle on and hide menu once page holder finishes its transition to cover it.
	   				$('.page-holder').children().unwrap('.page-holder');
	   			
				}
			}
			
			//move logo in middle of menu on desktop if logo is middle position
			if( $('.logo-in-middle').length && $(window).width() > $mobileMenuWidth && ! $('.li-logo-holder').length ){
				
				var middle = Math.floor( $(mainNavigationLi).length / 2 ) - 1;
				$( '<li class="menu-item li-logo-holder"></li>').insertAfter( mainNavigationLi.filter(':eq(' + middle + ')') ).prepend($('.site-logo'));
				//check if custom logo is there and hide site title if it is
				if( $('.site-top .custom-logo-link').is( ':visible' ) ){
					$('.site-top .site-title').hide();
				}
			}
			
		}
		
	}
	$(window).on('load resize', resizeMobileMenu); //run on load and resize
	
	
	
	
	//swipe right to open menu too
	page.on('swiperight', function(e) {
		if ( e.swipestart.coords[0] < 30 && ! siteNavContain.hasClass('toggled-on') ) {
	    menuToggle.trigger('click'); 
    }
	});
	
	
	//swipe right to open menu too
	page.on('swipeleft', function(e) {
		var $windowWidth = $(window).width() - 30;
		
		if ( e.swipestart.coords[0] > $windowWidth && ! $body.hasClass('sidebar-open') ) {
	    $('.sidebar-toggle').trigger('click'); 
    }
	});
	
	
	
	
	
	/*------- Sidebar Button Stuff --------*/ 
	
	
	//add toggle button. Hidden via css on desktop if not using cool sidebar.
 var $checksidebar = $('.js #secondary');
	if( $checksidebar.length ){
		$('#page').append('<button aria-expanded="false" class="sidebar-toggle" style="height: ' + $('.site-top').height() + 'px;">' + seasaltpressScreenReaderText.sidebar_icon + '</div>');
		
		$body.addClass('sidebar-active');
		
		
		$('.sidebar-toggle').on('click', function() {
			$body.toggleClass('sidebar-open');
			$('#secondary').toggleClass('sidebar-open');
			$(this).toggleClass('sidebar-open').attr('aria-expanded', $(this).hasClass('sidebar-open'));
			
		});
		
		
			//swipe left to open sidebar
		page.on('swipeleft', function(e) {
			//make sure swipe starts within 30 pixels from left edge
			var $windowWidth = $(window).width() - 30;
			
			if ( e.swipestart.coords[0] > $windowWidth && ! $body.hasClass('sidebar-open') ) {
		    $('.sidebar-toggle').trigger('click'); 
	    }
	    
		});
		
	
		//swipe right to close	 
	  $('#secondary').on('swiperight', function(e){
	    var $windowWidth = $(window).width() - $sidebarWidth;
	    
	    var $swipeSize = e.swipestop.coords[0] - e.swipestart.coords[0];
	  
	    
	    if ( e.swipestart.coords[0] > $windowWidth && $body.hasClass('sidebar-open') &&  $swipeSize > 20) {
	   		 $('.sidebar-toggle').trigger('click'); 
	  	}
	
	  });
		
		
	}
	
	/*------- Inline Sidebar Placement. --------*/ 
		//make regular sidebar inline. Remove if you dont want it to be inline but under site-top
	var $coolSidebar = $('.js .cool-sidebar #secondary');
	if( ! $coolSidebar.length && $checksidebar.length ){ //if not cool sidebar, but there is a sidebar
	 
		$(window).on('resize', function() {
		
			if( $(window).width() < $sidebarWidth && $('.content-sidebar-holder').length ){
				$('.content-sidebar-holder').children().unwrap($('.content-sidebar-holder'));
				$('.site-content').append( $('#secondary') );
				
			}
			if( $(window).width() > $sidebarWidth && ! $('.content-sidebar-holder').length ){
		
				$('.page .entry-content, .single .entry-content, .archive .posts-holder, .blog .posts-holder').wrap('<div class="wrap content-sidebar-holder"></div>');
				$('.content-sidebar-holder').append($('#secondary'));
			}
		}).resize();
			
	}
	
    
	
	
	
	
})( jQuery );
