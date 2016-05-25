<?php
/**
 * sea salt press Theme Customizer.
 * Sea salt press added to underscores here
 * @package sea_salt_press
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function seasaltpress_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	

/*--------------------------------------------------------------
# Adding more customizations to the wp customizer
--------------------------------------------------------------*/	
	//adding logo support
  $wp_customize->add_setting('your_theme_logo');
	
  // Add a control to upload the logo
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'your_theme_logo',
	array(
	'label' => __('Upload Logo'),
	'section' => 'title_tagline',
	'description' => 'Add logo image or svg here.'
	) ) );



/*--------------------------------------------------------------
# Adding sections
--------------------------------------------------------------*/



 	//add new section for site top presets and options
	$wp_customize->add_section( 'seasaltpress_presets', array(
  'title' => __( 'Site Top Options' ),
  'description' => __( 'Options and Quick Presets that also help you understand how it works. NOTE: Make sure to also set the sass variables in sass/style.scss for grid options as they cannot be set here.', 'seasaltpress' ),
  'panel' => '', // Not typically needed.
  'priority' => 160,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
  
) );



	//add new section for site layout manual
	$wp_customize->add_section( 'seasaltpress_manual', array(
  'title' => __( 'site top manual', 'seasaltpress' ),
  'description' => __( 'Manually set the top layout here.' ),
  'panel' => '', // Not typically needed.
  'priority' => 160,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
  
) );

//footer options
	$wp_customize->add_section( 'seasaltpress_footer', array(
  'title' => __( 'footer options', 'seasaltpress' ),
  'description' => __( 'Chose footer options.' ),
  'panel' => '', // Not typically needed.
  'priority' => 160,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
  
) );



 $wp_customize->add_setting('seasaltpress_footer_sidebars', array(
     'default'     => '1'

 ));

 $wp_customize->add_control('seasaltpress_footer_sidebars', array(
     'label'      => __('How many widgets for the footer?', 'seasaltpress'),
     'section'    => 'seasaltpress_footer',
     'type'    => 'select',
     'choices' => array(
        '1' => '1',
        '2' => '2',
        '3' => '3'
     )
 ));




/*--------------------------------------------------------------
# settings and controls for above sections
--------------------------------------------------------------*/

 //site top height in pixels
 $wp_customize->add_setting('site_top_height',
 	array(
	 	'default' => '100'
 	));
	
	$wp_customize->add_control('site_top_height',
	array(
	'label' => __('Site top pixel height'),
	'section' => 'seasaltpress_presets',
	'type' => 'number',
	'description' => 'Typically holds the logo and primary nav. Enter number.',
	'input_attrs' => array(
    'placeholder' => '100'
  ),
	) );
	
	
	
 //adding logo width
 $wp_customize->add_setting('logo_width',
 	array(
	 	'default' => '32%'
 	));
	

	$wp_customize->add_control('logo_width',
	array(
	'label' => __('Logo container width'),
	'section' => 'seasaltpress_presets',
	'type' => 'text',
	'description' => 'Enter Number with px or %. You can add logo image under Identity.',
	'input_attrs' => array(
    'placeholder' => __( '32%' )
  ),
	) );
	
	 //adding nav width
 $wp_customize->add_setting('wrap_nav',
 	array(
	 	'default' => 'yes'
 	));
	

	$wp_customize->add_control('wrap_nav',
	array(
	'label' => __('containt site top in wrap'),
	'section' => 'seasaltpress_presets',
	'type' => 'select',
	'choices' => array(
		'yes' => 'yes',
		'no' => 'no'
	),
	'description' => 'You can set wrap size via variables in scss'
	) );
	 
	   


//the presets
 $wp_customize->add_setting('top_layout',
 	array(
	 
	 	'default' => 'nav-right'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('top_layout',
	array(
	'label' => __('Layout Presets'),
	'section' => 'seasaltpress_presets',
	'type' => 'select',
	'description' => 'Quick presets that change the layout. Check Manual Layout to see the changes it makes.',
	'choices' => array(
		'nav-right' => 'nav on right',
		'nav-left' => 'nav on left',
		'nav-centered' => 'nav centered',
		'dashboard-nav' => 'dashboard nav'
	)
	 ) );
	 
	 
	 
	  
 $wp_customize->add_setting('dashboard_width',
 	array(
	 	'default' => '200px'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('dashboard_width',
	array(
	'label' => __('Mobile and Dashboard Width'),
	'section' => 'seasaltpress_nav',
	'type' => 'text',
	'description' => 'Width of mobile and dashboard menu.',
		'input_attrs' => array(
    'placeholder' => __( '200px' ))
	) );



//adding manual html for site top
 $wp_customize->add_setting('use_customizer',
 	array(
	 	'default' => 'yes'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('use_customizer',
	array(
	'label' => __('Use the customizer?'),
	'section' => 'seasaltpress_manual',
	'type' => 'radio',
	'description' => 'You can make your own layout in php in header.php and ignore presets and manual settings.',
		'choices' => array(
			'yes' => 'yes',
			'no' => 'no'
		)
	) );



//adding manual html for site top
 $wp_customize->add_setting('manual_layout',
 	array(
	 	'default' => '[logo]
<div class="mobilize">
  [primary_nav] 
</div>',
	 	'sanitize_callback' => 'sanitize_html_output'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('manual_layout',
	array(
	'label' => __('Manual Site Top Layout'),
	'section' => 'seasaltpress_manual',
	'type' => 'textarea',
	'description' => 'include the whole top with shortcodes available [logo] and [primary_nav]',
	'active_callback' => 'is_manual_on',
		'input_attrs' => array(
    'placeholder' => __( '200px' ))
	) );








	
	
}
add_action( 'customize_register', 'seasaltpress_customize_register' );






/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function seasaltpress_customize_preview_js() {

	wp_enqueue_script('seasaltpress_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}

add_action( 'customize_preview_init', 'seasaltpress_customize_preview_js' );



/**
	* add changes to the controls based on selections. does not run on refresh.
	*/
	
function seasaltpress_customizer_controls_js(){
	
  wp_enqueue_script('seasaltpress_customizer_controls_js', get_template_directory_uri() . '/js/customizer_controls.js', array( 'customize-controls' ), '2151215', true );
}


add_action( 'customize_controls_enqueue_scripts', 'seasaltpress_customizer_controls_js' );




//callbacks

function is_manual_on(){
	return (get_theme_mod('use_customizer') === 'yes');
}


function sanitize_html_output($value){
   return	wp_kses_post($value);
}







