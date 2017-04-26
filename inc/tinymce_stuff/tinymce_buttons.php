<?php
	



//adding tiny mce plugin buttons	
add_action( 'init', 'snp_buttons' );
function snp_buttons() {
    add_filter( "mce_external_plugins", "snp_add_buttons" );
    add_filter( 'mce_buttons', 'snp_register_buttons' );
    wp_enqueue_style('tinymce_button_styles', get_template_directory_uri() . '/inc/tinymce_stuff/custom-button-style.css');	
}

function snp_add_buttons( $plugin_array ) {
    $plugin_array['snp'] = get_template_directory_uri() . '/inc/tinymce_stuff/tinymce_buttons.js';
    return $plugin_array;
}

function snp_register_buttons( $buttons ) {
	
	$snp_buttons = array(
	'columns',
	'content-column',
	'button-link',
	'break-out',
	'wrap',
	'prism',
	'code'
	
);


    $buttons = array_merge( $buttons, $snp_buttons); 
    return $buttons;
}


//also adding javascript to tinymce visual editor
add_action( 'after_wp_tiny_mce', 'custom_after_wp_tiny_mce' );
function custom_after_wp_tiny_mce() {
	
    printf( '<script type="text/javascript" src="%s"></script>',  get_template_directory_uri() . '/inc/tinymce_stuff/ssp_tiny_mce.js' );
}