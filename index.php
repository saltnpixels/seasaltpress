<?php
/**
 * The main template file
 *
 *
 * It is used to display a page when nothing more specific matches a query.
 * An archive-header.php file can be used
 * E.g., it puts together the home page when no home.php file exists.
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
			$template       = '';
			$template_class = '';
			$post_type      = get_post_type();
			//show page header if it exists for this archive
			$archive_header_page = (int) get_theme_mod( 'seasaltpress_archive_header_' . $post_type );

			if ( $archive_header_page != '' ) {
				if ( file_exists( locate_template( 'template-parts/' . $post_type . '/archive-header.php' ) ) ) {
					include( locate_template( 'template-parts/' . $post_type . '/archive-header.php' ) );
				} else {
					include( locate_template( 'template-parts/post/archive-header.php' ) );
				}

				$template = get_page_template_slug( $archive_header_page );
				if ( $template == 'sidebar-left.php' ) {
					$template_class = 'sidebar-left';
				}
			} else {
				//without a archive-header set in customizer it defualts to a header.
				//if its the blog page or an archive post type and its not set as your home page give title h1, otherwise, its front page and h1 is given to your logo or something before...
				if ( ( is_home() || is_post_type_archive() ) && ! is_front_page() ) : ?>
					<header class="page-header">
						<div class="header-content">
							<h1 class="page-title"><?php single_post_title(); ?></h1>
						</div>
					</header>
				<?php else :  //its front page and its blog. put in h2 because logo is h1 ?>
					<header class="page-header">
						<div class="header-content">
							<h2 class="page-title"><?php _e( 'Articles', 'seasaltpress' ); ?></h2>
						</div>
					</header>
				<?php endif;

			} //end header output
			?>

			<?php
			if ( have_posts() ) :
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
