<?php



/*--------------------------------------------------------------
# add shortcode to text widgets
--------------------------------------------------------------*/
add_filter('widget_text', 'do_shortcode');

/*--------------------------------------------------------------
# allowing svg upload for logo in customizer
--------------------------------------------------------------*/

//quickpress add svg as logo allowed in uploader
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');



/*--------------------------------------------------------------
# This allows for a logo in middle of nav items
--------------------------------------------------------------*/
//just add [logo] to menu item description
function shortcode_menu_description( $item_output, $item ) {
    if ( !empty($item->description)) {
         $output = do_shortcode($item->description);  
         if ( $output != $item->description )
               $item_output = $output;   
        }
    return $item_output;
}
add_filter("walker_nav_menu_start_el", "shortcode_menu_description" , 10 , 2);




/*--------------------------------------------------------------
# Shortcodes
--------------------------------------------------------------*/




/*
 * [logo] 
 * outputs logo in link in either h1 or p
*/
function logo(){
	
	//get theme logo or text if none uploaded
	if ( get_theme_mod( 'your_theme_logo' ) ) :
				
				$logo = get_theme_mod( 'your_theme_logo' );
			
			//if its a svg logo output contents so we can style with css
			$logo = preg_match('/\.(svg)(?:[\?\#].*)?$/i', $logo, $matches) ? file_get_contents($logo) : '
			<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">
			<img src="' . $logo .'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" /></a>';
		
		
			 else : //no theme mod
			 
			 	$logo = '
			 	<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name') .'
					</a>
					';
 
			endif; //if theme mod 
			
			if(is_front_page()){
				return '<div class="site-logo"><h1>' . $logo . '</h1></div>';
			}
			
			else{
			return '<div class="site-logo"><p>' . $logo . '</p></div>';
			}
			
}
add_shortcode('logo', 'logo');


/*
 * [year]
*/
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');


/*
 * [primary nav]
 * outputs primary nav. used in customizer
*/
function primary_nav(){
		
/*
		$dashboard_back = '';
		if( get_theme_mod('dashboard_back') == 'yes'){
			$dashboard_back  = '<div class="dashboard-back"></div>';
		}
*/
	return '
	<nav id="site-navigation" class="main-navigation" role="navigation">'	 .
			wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'site-menu', 'echo' => false ) ) . '
		</nav><!-- #site-navigation -->';
	
}

add_shortcode('primary_nav', 'primary_nav');



/*
 * [site_description]
*/
function site_description(){
	return '<p class="site-description">' . get_bloginfo( 'description') . '</p>';
}
add_shortcode('site_description', 'site_description');


/*--------------------------------------------------------------
# editor styles to add to mce editor
--------------------------------------------------------------*/

function quickpress_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );

}
add_action( 'admin_init', 'quickpress_add_editor_styles' );



/*--------------------------------------------------------------
# dealing with subscribers on the site
--------------------------------------------------------------*/

## function to check users role

function check_user_role( $role, $user_id = null ) {
 
    if ( is_numeric( $user_id ) )
	$user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
 
    if ( empty( $user ) )
	return false;
 
    return in_array( $role, (array) $user->roles );
}


##filters to redirect subscribers and not show admin bar
//to do change to current_user_can

// disable admin bar. most ppl dont want subscribers getting anywhere
function disable_admin_bar() { 
	if( check_user_role('subscriber') )
		add_filter('show_admin_bar', '__return_false');	
}
add_action( 'after_setup_theme', 'disable_admin_bar' );
 
 
 /**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
function redirect_admin(){
	if( check_user_role('subscriber') ){
		wp_redirect( site_url() );
		exit;		
	}
}
add_action( 'admin_init', 'redirect_admin' );




