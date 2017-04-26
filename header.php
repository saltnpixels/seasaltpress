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
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'snp' ); ?></a>
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="bar-one">–</span><span class="bar-two">–</span></button>
	
	<?php
		//get theme mod checking if a wrap is included. if yes output div with class wrap and flex. else just site top
		$wrap_nav = get_theme_mod('wrap_nav', 'yes');
		
   ?>
   
	<div class="site-top <?php if($wrap_nav == 'no'){ echo 'flex'; } ?>">
		<?php if($wrap_nav == 'yes'){ echo '<div class="wrap flex">'; } ?>
		
			<?php
				//if using customizer output from there. else do your own thing in here!
				if(get_theme_mod('use_customizer', 'yes') == 'yes'):
					echo do_shortcode(get_theme_mod('manual_layout', '[logo] <div id="mobilize">[primary_nav]</div>'));
					
				
				else:
			?>
			
			
			
			
			
			<?php
			
			//YOUR OWN CODE GOES HERE
			
				echo logo();
			?>
			
			<div id="mobilize">
				
		 	<?php
		 		echo	primary_nav(); 
		 	?>
		 	
	 		</div>
	 		
	 		
	 		
	 	
	 							

	 
	 
	 
		<?php 
			//END OF YOUR OWN CODE
			endif;
			
			if($wrap_nav == 'yes'){ echo '</div> <!-- .wrap-->'; } 
			?>
	</div>	<!-- end .site-top -->
	 	
	 <?php 	
	 	if(is_post_type_archive() || is_home() || is_search() || is_archive()){
	 		get_header('archives'); 
		}