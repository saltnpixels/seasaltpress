<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until #primary
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sea_salt_press
 *
 * the customizer outputs the top navigation and logo. Feel free to adjust and change under manual. 
 Functions logo() and primary_nav() will output those items.
 logo() will check if its front page and output in h1 tags. otherwise in p tags.
 
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div id="content" class="site-content">
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'seasaltpress' ); ?></a>
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i></button>
	<?php
	
	//check out wp customizer for these options.
	//for manual change the settings under else:
	

	/*--------------------------------------------------------------
	 # sea salt press customizer styles
	 --------------------------------------------------------------*/
	 	require get_template_directory() . '/inc/customizer_styles.php';
	 //site top alt is if you want a menu area on side and top. like a dashboard area and a top area.
	 //if you want it show on desktop remove the class hide-on-desktop
	 ?>
	
	  
	 <div class="site-top">
   <?php echo get_theme_mod('wrap_nav', 'yes') == 'yes' ? '<div class="wrap">' : '<div class="nav-holder">';	
	 	
	 	if( get_theme_mod('use_customizer') === 'yes'){
		 	echo do_shortcode(get_theme_mod('manual_layout'));
		}
	 	
  	else{  
		 
		 
		 	//REAPLACE BELOW WITH YOUR OWN MANUAL SITE TOP
	 	
	 		echo logo();
	 		?>
	 		<div id="mobilize">
		 	<?php
		 		echo	primary_nav(); 
		 	?>
	 		</div>
					
	
	<?php
	 	}
	 ?>
	 
	 
	 
	 
		</div>
	</div>	<!-- end .site-top -->
	 	
	 <?php 	
	 	if(is_post_type_archive() || is_home() || is_search()){
	 		get_header('archives'); 
		}