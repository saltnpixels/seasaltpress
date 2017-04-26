<?php
/**
 * The is similar to index... basically the same thing... is it needed? *
 * 
 */

get_header(); ?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
       <div class="archive-grid">
		<?php
		if ( have_posts() ) :
   
						/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				 ?>
				
					 <?php
				get_template_part( 'template-parts/content', get_post_type() );
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
