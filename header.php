<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * Some stuff are added to the head via wp_head in functions.php including fonts, style.css and more
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	
	<div class="site-top">	
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'seasaltpress' ); ?></a>
	
	<?php 
	
	if( get_theme_mod('site_top_use_customizer', 'yes') == 'yes' ):
		
		$wrap =  get_theme_mod('site_top_wrap', 'wrap') == 'wrap' ? 'wrap' : '';
		$logo_position = get_theme_mod('site_top_layout', 'logo-left');
	?>
			
		<div class="site-top-inner-container stay-on-mobile flex <?= $wrap . ' ' . $logo_position; ?>">
			<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
				<?php
					if( ! get_theme_mod('cool_menu') ){
						echo '<span class="bar-one">–</span><span class="bar-two">–</span>';
					}
					else{
						 echo seasaltpress_get_svg( array('icon'=>'menu')); 
					}
				?>
		</button>

			<?= seasaltpress_logo(); ?>
			<div class="mobile-popout">
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php _e( 'Top Menu', 'seasaltpress' ); ?>">
					<?php wp_nav_menu( array(
						'theme_location' => 'top',
						'menu_id'        => 'top-menu',
					) ); ?>
				</nav><!-- #site-navigation -->
			</div>
			
		</div>
	</div>
		
	<?php endif; 
		
		//ADD OWN CODE HERE IF NOT USING CUSTOMIZER
		
	?>
	


	<div id="content" class="site-content">
	
