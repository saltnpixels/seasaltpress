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

//if its a portfolio peice dont show unless it had a pop up image
$pop_up = get_post_meta(get_the_ID(), 'pop_up_image', true);

if(get_post_type() == 'snp_portfolio'){
	wp_redirect(home_url('/portfolio/#item-'. get_the_ID() ) );
	exit;
}


get_header(); ?>


		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		
			<?php
			while ( have_posts() ) : the_post();
		
				get_template_part( 'template-parts/content-single', get_post_format() );
		
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
get_footer();
