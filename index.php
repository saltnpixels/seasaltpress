<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 * seasaltpress: if you dont want the sidebar remove classes col-3-4 and the sidebar.
 *
 * seasaltpress - a archive header is shown at top right before wrap.
 * For no sidebar simply remove col-3-4 and the get_sidebar call
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area col-3-4">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :
   
						/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();

?>
</div> <!-- wrap -->
<?php
get_footer();
