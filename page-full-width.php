<?php
/**
 * Template Name: Full Width
 *
 * This is the template that displays pages with no wrap and gives you full width, but still has  a page header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */

get_header(); ?>

	
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->


<?php
get_footer();
