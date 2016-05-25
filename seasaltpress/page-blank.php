<?php
/**
 * Template Name: blank no header
 *
 * This is the template that displays pages with no wrap and gives you full width. It also has no header. You make that in the content. This is good for front pages and pages with a lot of styling and sections.
 *You have full control over the article
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */

get_header(); ?>

<?php //get_template_part('template-parts/content', 'header'); page blank usually means you will make your own header via the page editor.  ?>
	
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
