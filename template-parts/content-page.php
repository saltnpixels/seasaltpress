<?php
/**
 * Template part for displaying page content in page.php.
 * This is not used on a page with a sidebar
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */

?>

<?php
	$is_page_blank = is_page_template('page-blank.php');
	
	$is_content_column = is_page_template() == false ? 'content-column' : '';
		
	?>
	
	
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	 
	<?php
		if(! $is_page_blank){
		 get_template_part('template-parts/content', 'header');
		 }
	 ?>

	
	
	<div class="entry-content <?php echo $is_content_column ?>">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'seasaltpress' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'seasaltpress' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
