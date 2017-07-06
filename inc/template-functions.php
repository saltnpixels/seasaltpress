<?php
/**
 * Additional features to allow styling of the templates
 *
* @package Sea_Salt_Press
 * @since 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function seasaltpress_body_classes( $classes ) {
	// Add class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'seasaltpress-customizer';
	}

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'seasaltpress-front-page';
	}

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}
// 	adds cool menu class if active in customizer. jquery then can use this to activate the menu as well as css
	if( get_theme_mod('cool_menu') ){
		$classes[] = 'cool-menu';
	}
// 	add cool-sidebar class if active
	if( get_theme_mod('cool_sidebar') ){
		$classes[] = 'cool-sidebar';
	}

	// Add class if sidebar is used.
	if ( is_active_sidebar( 'sidebar-1' )  ) {
		$classes[] = 'has-sidebar';
	}
	
	
	// adds users role as class
	if( is_user_logged_in()){
		$current_user = new WP_User(get_current_user_id());
		$user_role = array_shift($current_user->roles);
		$classes[] = 'role-'. $user_role;
	}
	



	// Add class if the site title and tagline is hidden.
	if ( 'blank' === get_header_textcolor() ) {
		$classes[] = 'title-tagline-hidden';
	}

	

	return $classes;
}
add_filter( 'body_class', 'seasaltpress_body_classes' );


/**
 * Checks to see if we're on the static homepage or not.
 */
function seasaltpress_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}


