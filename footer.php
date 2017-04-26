<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sea_salt_press
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php
				if ( is_active_sidebar( 'sidebar-2' ) ) {
					get_sidebar('footer');
					}
				else{
					?>
				
		      <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'snp' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'snp' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'snp' ), 'snp', '<a href="http://saltnpixels.com" rel="designer">shamai</a>' ); ?>
				<?php } ?>
		
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
