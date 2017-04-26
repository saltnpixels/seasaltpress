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
function snp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	

/*--------------------------------------------------------------
# Adding more customizations to the wp customizer
--------------------------------------------------------------*/	



/*--------------------------------------------------------------
# Adding sections
--------------------------------------------------------------*/



 	//add new section for site top options and options
	$wp_customize->add_section( 'snp_options', array(
  'title' => __( 'Site Top Options' ),
  'description' => __( 'Options. NOTE: Make sure to also set the sass variables in sass/style.scss for grid options as they cannot be set here.', 'snp' ),
  'panel' => '', // Not typically needed.
  'priority' => 160,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
  
) );



	//add new section for site layout manual
	$wp_customize->add_section( 'snp_layout', array(
  'title' => __( 'site top layouts', 'snp' ),
  'description' => __( 'Preset or Manually set the top layout here.' ),
  'panel' => '', // Not typically needed.
  'priority' => 160,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
  
) );

//footer options
	$wp_customize->add_section( 'snp_footer', array(
  'title' => __( 'footer options', 'snp' ),
  'description' => __( 'Chose footer options.' ),
  'panel' => '', // Not typically needed.
  'priority' => 160,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
  
) );







/*--------------------------------------------------------------
# settings and controls for above sections
--------------------------------------------------------------*/

//add more footer widgets
 $wp_customize->add_setting('snp_footer_sidebars', array(
     'default'     => '1'

 ));

 $wp_customize->add_control('snp_footer_sidebars', array(
     'label'      => __('How many widgets for the footer?', 'snp'),
     'section'    => 'snp_footer',
     'type'    => 'select',
     'choices' => array(
        '1' => '1',
        '2' => '2',
        '3' => '3'
     )
 ));

	
	
	

	
//adding a wrap inside site top
 $wp_customize->add_setting('wrap_nav',
 	array(
	 	'default' => 'yes'
 	));
	

	$wp_customize->add_control('wrap_nav',
	array(
	'label' => __('containt site top in wrap'),
	'section' => 'snp_layout',
	'type' => 'select',
	'choices' => array(
		'yes' => 'yes',
		'no' => 'no'
	),
	'description' => 'You can set wrap size via variables in scss'
	) );
	 


//adding manual html yourself
 $wp_customize->add_setting('use_customizer',
 	array(
	 	'default' => 'yes'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('use_customizer',
	array(
	'label' => __('Use the customizer?'),
	'section' => 'snp_layout',
	'type' => 'radio',
	'description' => 'You can make your own layout in php in header.php and ignore presets and manual settings.',
		'choices' => array(
			'yes' => 'yes',
			'no' => 'no'
		)
	) );
		   


//preset options. the presets just fill the manual textarea below it.
 $wp_customize->add_setting('preset_layout',
 	array(
	 
	 	'default' => 'nav-right'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('preset_layout',
	array(
	'label' => __('Layout Presets'),
	'section' => 'snp_layout',
	'type' => 'select',
	'active_callback' => 'is_manual_on',
	'description' => 'Quick presets that change the layout. Check Manual Layout to see the changes it makes.',
	'choices' => array(
		'nav-right' => 'nav on right',
		'nav-left' => 'nav on left',
		'nav-centered' => 'nav centered'
	)
	 ) );
	 
	 
	 


//adding preset html for site top
 $wp_customize->add_setting('manual_layout',
 	array(
	 	'default' => '[logo]
<div id="mobilize">
  [primary_nav] 
</div>',
	 	'sanitize_callback' => 'sanitize_html_output'
 	));
	
	// Add a control to upload the logo
	$wp_customize->add_control('manual_layout',
	array(
	'label' => __('Manual Site Top Layout'),
	'section' => 'snp_layout',
	'type' => 'textarea',
	'description' => 'include the whole top with shortcodes available [logo] and [primary_nav] and [site_description]',
	'active_callback' => 'is_manual_on',
		'input_attrs' => array(
    'placeholder' => __( '[logo]
<div id="mobilize">
  [primary_nav] 
</div>' ))
	) );



	
	
}
add_action( 'customize_register', 'snp_customize_register' );






/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function snp_customize_preview_js() {

	wp_enqueue_script('snp_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}

add_action( 'customize_preview_init', 'snp_customize_preview_js' );



/**
	* add changes to the controls based on selections. does not run on refresh.
	*/
	
function snp_customizer_controls_js(){
	
  wp_enqueue_script('snp_customizer_controls_js', get_template_directory_uri() . '/js/customizer_controls.js', array( 'customize-controls' ), '2151215', true );
}


add_action( 'customize_controls_enqueue_scripts', 'snp_customizer_controls_js' );




//callbacks

function is_manual_on(){
	return (get_theme_mod('use_customizer') === 'yes');
}


function sanitize_html_output($value){
   return	wp_kses_post($value);
}







