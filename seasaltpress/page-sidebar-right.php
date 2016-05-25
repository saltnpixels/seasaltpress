<?php
/**
 * Template Name: page sidebar right
 * The template for displaying page with sidebar.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */



get_header(); ?>

<?php get_template_part('template-parts/content', 'header'); ?>	

<div class="wrap">
	<div id="primary" class="content-area col-3-4">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page-sidebar' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->


	<?php get_sidebar();	?>
	
</div> <!-- .wrap -->
<?
get_footer();
