<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
				update_field('relationacf', array(133, 426));
					//if the post type has its own folder it must also have its own set of post format files too.
					$post_type = get_post_type();
					if(file_exists( locate_template( 'template-parts/' . $post_type . '/content.php' ) ) ){
						get_template_part( 'template-parts/' . $post_type . '/content', get_post_format() );
					}
					else{
						//defualt to getting the post folder if the new post type does not have a folder
						get_template_part( 'template-parts/post/content', get_post_format() );
					}
					

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

					the_post_navigation( array(
						'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'seasaltpress' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'seasaltpress' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . seasaltpress_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
						'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'seasaltpress' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'seasaltpress' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . seasaltpress_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
					) );

				endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->


<?php get_footer();
