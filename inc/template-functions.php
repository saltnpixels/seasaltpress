<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
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
	
	if( get_theme_mod('cool_menu') ){
		$classes[] = 'cool-menu';
	}
	
	if( get_theme_mod('cool_sidebar') ){
		$classes[] = 'cool-sidebar';
	}

	// Add class if sidebar is used.
	if ( is_active_sidebar( 'sidebar-1' )  ) {
		$classes[] = 'has-sidebar';
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


