<?php
/**
 * The sidebars for the footer area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sea_salt_press
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>


<div class="col"><?php dynamic_sidebar( 'sidebar-2' ); ?></div>	
	
	<?php if(get_theme_mod('snp_footer_sidebars', '1') > '1'){ ?>
				<div class="col"><?php dynamic_sidebar( 'sidebar-3' ); ?></div>
	<?php
	}
	
	 if(get_theme_mod('snp_footer_sidebars', '1') > '2'){  ?>
			<div class="col"><?php	dynamic_sidebar( 'sidebar-4' ); ?></div>
			<?php
	}
	?>

