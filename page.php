
<?php
/**
 * The template for displaying all pages.
 * 
 * This is the template that displays all pages by default.
 * By default it does not have a sidebar. 
 * To default with a sidebar change the file name of one of the sidebar ones to page.php and this one to page-no-sidebar.php
 * the difference betweena a sidebar or not is also whether the header of article is inside or above article.
 * no sidebar means the header is inside.
 
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
