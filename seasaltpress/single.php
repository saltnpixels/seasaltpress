<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sea_salt_press
 *
 * you can put class col-3-4 on primary and have columns. check out page sidebar right for ideas. otherwise use a smaller column and center it down the page
 */

get_header(); ?>



<div class="wrap">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		
			<?php
			while ( have_posts() ) : the_post();
		
				get_template_part( 'template-parts/content', get_post_format() );
		
				the_post_navigation();
		
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
		
			endwhile; // End of the loop.
			?>
		
			</main><!-- #main -->
		</div><!-- #primary -->
		
		<?php
		//if having a sidebar place a col-3-4 or some column class on primary above. also use content-sidebar template part. see page-sidebar-right for how its done
		
		//get_sidebar();
		?>
	</div>
<?php
get_footer();
