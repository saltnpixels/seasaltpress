<?php
/**
 * Sea Salt Press: Customizer
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
 * @since 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function seasaltpress_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	
	//$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'seasaltpress_customize_partial_blogname',
	) );
	
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'seasaltpress_customize_partial_blogdescription',
	) );



/**
 * Theme options.
 */
$wp_customize->add_section( 'theme_options', array(
	'title'    => __( 'Theme Options', 'seasaltpress' ),
	'priority' => 130, // Before Additional CSS.
) );

$wp_customize->add_section( 'post_types', array(
	'title'    => __( 'Post Type Archives', 'seasaltpress' ),
	'priority' => 130, // Before Additional CSS.
) );


/**
 * Layout of Site top
 */
$wp_customize->add_setting('site_top_use_customizer',
 	array(
	 	'default' => 'yes'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('site_top_use_customizer',
	array(
	'label' => __('Use the customizer?'),
	'section' => 'theme_options',
	'type' => 'radio',
	'description' => 'You can make your own layout in php in header.php and ignore presets and manual settings.',
		'choices' => array(
			'yes' => 'yes',
			'no' => 'no'
		)
	) );


/**
 * Nav Menu and Logo Options
 */
$wp_customize->add_setting('site_top_wrap',
 	array(
	 	'default' => 'yes',
	 	'transport' => 'postMessage',
 	));
	

	$wp_customize->add_control('site_top_wrap',
	array(
		'label' => __('contain the site top in .wrap'),
		'section' => 'theme_options',
		'type' => 'select',
		'choices' => array(
			'wrap' => 'yes',
			'' => 'no'
		),
		'description' => 'You can set wrap size via variables in scss'
	) );
	
/*
$wp_customize->selective_refresh->add_partial( 'site_top_wrap', array(
	'selector'  => '.site-top-inner-container',
	'render_callback' => 'seasaltpress_customize_partial_site_top_wrap',
) );
*/




/**
 * Layout of Site top
 */
$wp_customize->add_setting('site_top_layout',
 	array(
	 	'default' => 'logo-left',
	 	'transport' => 'postMessage'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('site_top_layout',
	array(
	'label' => __('Logo Position'),
	'section' => 'theme_options',
	'type' => 'select',
	'description' => 'You can make your own layout in php in header.php and ignore presets and manual settings.',
		'choices' => array(
			'logo-left' => 'logo-left',
			'logo-right' => 'logo-right',
			'logo-center' => 'logo-center',
			'logo-center-under' => 'logo-center-under',
			'logo-in-middle' => 'logo-in-middle',
			'no-logo' => 'no-logo'
		)
	) );


/*
 $wp_customize->selective_refresh->add_partial( 'site_top_layout', array(
	'selector'  => '.site-top-inner-container',
) );
*/


/**
 * Add cool menu capability. app like menu on mobile
 *
 */
$wp_customize->add_setting( 'cool_menu',
	array(
		'default'=> false,
	));
$wp_customize->add_control( 'cool_menu', 
	array(
		'label' => __('Enable Cool Mobile Menu'),
		'section' => 'theme_options',
		'type' => 'checkbox'
	));	
	

/**
 * Add cool sidebar capability. 
 *
 */
$wp_customize->add_setting( 'cool_sidebar',
	array(
		'default'=> false,
	));
$wp_customize->add_control( 'cool_sidebar', 
	array(
		'label' => __('Enable Cool Sidebar'),
		'section' => 'theme_options',
		'type' => 'checkbox'
	));	
	
	
//add post type descriptions
$seasaltpress_post_types = get_post_types(array('_builtin'=>false, 'has_archive'=>true), 'objects');
$seasaltpress_post_types[] = get_post_type_object('post');
foreach( $seasaltpress_post_types as $post_type ){
	
$wp_customize->add_setting( 'seasaltpress_archive_header_' . $post_type->name,
	array(
		'default'=> '',
));
	
$wp_customize->add_control( 'seasaltpress_archive_header_' . $post_type->name, array(
  'label' => __( 'Archive Header For ', 'seasaltpress' ) . ucwords($post_type->labels->singular_name),
  'type' => 'dropdown-pages',
  'allow_addition' => true,
  'section' => 'post_types',
  'description' => __('Set a page to be used to display the header for this archive. Note: Post type must have an archive page.', 'seasaltpress'),
) );


}


               
}
add_action( 'customize_register', 'seasaltpress_customize_register' );




/**
 * Render the site title for the selective refresh partial.
 *
 * @since Sea Salt Press 1.0
 * @see seasaltpress_customize_register()
 *
 * @return void
 */
function seasaltpress_customize_partial_blogname() {
	bloginfo( 'name' );
}



/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Sea Salt Press 1.0
 * @see seasaltpress_customize_register()
 *
 * @return void
 */
function seasaltpress_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Return whether we're previewing the front page and it's a static page.
 */
function seasaltpress_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Return whether we're on a view that supports a one or two column layout.
 */
function seasaltpress_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}



/**
 * Bind JS handlers to instantly live-preview changes.
 */
function seasaltpress_customize_preview_js() {
	wp_enqueue_script( 'seasaltpress-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'seasaltpress_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function seasaltpress_panels_js() {
	wp_enqueue_script( 'seasaltpress-customize-controls', get_theme_file_uri( '/assets/js/customize-controls.js' ), array(), '1.0', true );
}
//add_action( 'customize_controls_enqueue_scripts', 'seasaltpress_panels_js' );



