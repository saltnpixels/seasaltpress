<?php
/**
 * Template part for displaying page content in page-sidebar.php.
 * This template has no header inside the article. The article is insdie #primary which should be floated with a column class
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 * 
 * with sidebar, header is not inside article. its before primary and is outside the loop
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'snp' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'snp' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
