<?php
/**
 * The template for displaying archive pages.
 * You can make a custom header by creating a page called archive-[post-type] wich outputs before primary
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */

get_header(); ?>

	
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<div class="archive-grid">
			<?php
			if ( have_posts() ) : ?>
			
					<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
	
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_type() );
	
				endwhile;
	?>
		</div>
			<?php
				the_posts_navigation();
	
			else :
	
				get_template_part( 'template-parts/content', 'none' );
	
			endif; ?>
	
			</main><!-- #main -->
		</div><!-- #primary -->


<?php
get_footer();
