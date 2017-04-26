<?php
/**
 * Template part for displaying posts.
 * to show excerpts on the index page follow content-search
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */
 
 
echo get_post_meta(get_the_ID(), 'snp_extra_styles', true);


?>






<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		    
			<?php	get_template_part('template-parts/content', 'header'); ?>
				
	<div class="content-column">
		<div class="entry-content">
			<?php if(has_post_thumbnail()): ?>
				<div class="featured-image"> <?php the_post_thumbnail();?> </div>
<?php				
	endif;
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'snp' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
	
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'snp' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

	<footer class="entry-footer">
		

	</footer><!-- .entry-footer -->
	
</div>
</article><!-- #post-## -->
