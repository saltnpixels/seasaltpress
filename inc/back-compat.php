<?php
/**
 * Sea Salt Press back compat functionality
 *
 * Prevents Sea Salt Press from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
 * @since Sea Salt Press 1.0
 */

/**
 * Prevent switching to Sea Salt Press on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Sea Salt Press 1.0
 */
function seasaltpress_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'seasaltpress_upgrade_notice' );
}
add_action( 'after_switch_theme', 'seasaltpress_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Sea Salt Press on WordPress versions prior to 4.7.
 *
 * @since Sea Salt Press 1.0
 *
 * @global string $wp_version WordPress version.
 */
function seasaltpress_upgrade_notice() {
	$message = sprintf( __( 'Sea Salt Press requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'seasaltpress' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Sea Salt Press 1.0
 *
 * @global string $wp_version WordPress version.
 */
function seasaltpress_customize() {
	wp_die( sprintf( __( 'Sea Salt Press requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'seasaltpress' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'seasaltpress_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Sea Salt Press 1.0
 *
 * @global string $wp_version WordPress version.
 */
function seasaltpress_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Sea Salt Press requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'seasaltpress' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'seasaltpress_preview' );
