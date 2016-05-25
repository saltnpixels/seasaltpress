<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sea_salt_press
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>


	<?php dynamic_sidebar( 'sidebar-2' ); ?>
	
	<?php if(get_theme_mod('seasaltpress_footer_sidebars', '1') > '1'){
				dynamic_sidebar( 'sidebar-3' );
	}
	?>
	
	<?php if(get_theme_mod('seasaltpress_footer_sidebars', '1') > '2'){
				dynamic_sidebar( 'sidebar-4' );
	}
	?>

