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
 * snp: if you dont want the sidebar remove classes col-3-4 and the sidebar.
 *
 * snp - a archive header is shown at top right before wrap.
 * For no sidebar simply remove col-3-4 and the get_sidebar call
 */

get_header();
//header archives is output here.
 ?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div class="archive-grid">
		<?php
		if ( have_posts() ) :
   
						/* Start the Loop */
			while ( have_posts() ) : the_post();

				 ?>
				
					 <?php
					 
				get_template_part( 'template-parts/content', get_post_format() );
					?>
			
				
			<?php
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
