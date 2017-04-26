<?php
/**
 * Template Name: page sidebar left
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

<?php   
   //header outside loop. above article and sidebar.
   get_template_part('template-parts/content', 'header'); 
?>	

<div class="wrap flex content-sidebar-holder">
   
   <?php get_sidebar(); ?>
   
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




</div> <!-- wrap -->

<?php
get_footer();
