<?php
/**
 * The template for displaying archive pages for post types and categories
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sea_Salt_Press
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			$template       = '';  //template file name
			$template_class = ''; //class to apply to post list. This allows for a sidebar if wanted.
			$post_type      = get_post_type();

			//show page as header if it exists for this archive. Set in customizer.
			$archive_header_page = (int) get_theme_mod( 'seasaltpress_archive_header_' . $post_type );

			if ( $archive_header_page != '' ) {
				if ( file_exists( locate_template( 'template-parts/' . $post_type . '/archive-header.php' ) ) ) {
					include( locate_template( 'template-parts/' . $post_type . '/archive-header.php' ) );
				} else {
					include( locate_template( 'template-parts/post/archive-header.php' ) );
				}

				$template = get_page_template_slug( $archive_header_page );
				//defaults to right side. Need to check if it should be on left.
				if ( $template == 'sidebar-left.php' ) {
					$template_class = 'sidebar-left';
				}
			} else {

				//default header for archives

				//if its not the front page give title h1 
				if ( is_post_type_archive() && ! is_front_page() ) : ?>
					<header class="page-header">
						<div class="header-content">
							<?php the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
						</div>
					</header>

				<?php else : ?>
					<header class="page-header">
						<div class="header-content">
							<?php the_archive_title( '<h2 class="page-title">', '</h2>' ); ?>
						</div>
					</header>
				<?php endif;
			} //end header output
			?>


			<?php
			if ( have_posts() ) :
				//javascript will put this div inside a div content-sidebar-holder if regular sidebar is wanted and sidebar will be moved inside
				echo '<div class="posts-holder ' . $template_class . '">';
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					  
					 */
					if ( file_exists( locate_template( 'template-parts/' . get_post_type() . '/content-' . get_post_format() ) ) ) {
						get_template_part( 'template-parts/' . get_post_type() . '/content', get_post_format() );
					} else {
						get_template_part( 'template-parts/post/content', get_post_format() );
					}


				endwhile;


				the_posts_pagination( array(
					'prev_text'          => seasaltpress_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'seasaltpress' ) . '</span>',
					'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'seasaltpress' ) . '</span>' . seasaltpress_get_svg( array( 'icon' => 'arrow-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'seasaltpress' ) . ' </span>',
				) );
				echo '</div>';

			else :

				get_template_part( 'template-parts/post/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
if ( $template == 'sidebar-right.php' || $template == 'sidebar-left.php' ) {
	get_sidebar();
}
?>


<?php get_footer();

