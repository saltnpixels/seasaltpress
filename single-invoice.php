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
$pass = '';

if(!empty($_GET['invoice_pass']) ){
	
 $pass =  $_GET['invoice_pass'];
 }

 
if($pass !== get_post_meta(get_the_ID(), 'invoice_pass', true) ){
	wp_redirect(home_url() );
	exit;
} 


get_header();  ?>


		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		
			<?php
			while ( have_posts() ) : the_post();
		
				get_template_part( 'template-parts/content-single', get_post_type() );
		
				
		
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
