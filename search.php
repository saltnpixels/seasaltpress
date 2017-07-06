<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Sea_Salt_Press
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header class="page-header">
				<div class="header-content">
					<?php if ( have_posts() ) : ?>
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'seasaltpress' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					<?php else : ?>
						<h1 class="page-title"><?php _e( 'Nothing Found', 'seasaltpress' ); ?></h1>
					<?php endif; ?>
				</div>
			</header><!-- .page-header -->


			<?php
			if ( have_posts() ) :
				echo '<div class="posts-holder">';
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					if ( file_exists( locate_template( 'template-parts/' . get_post_type() . '/content-' . get_post_format() ) ) ) {
						get_template_part( 'template-parts/' . get_post_type() . '/content', get_post_format() );
					} else {
						get_template_part( 'template-parts/post/content', get_post_format() );
					}

				endwhile; // End of the loop.

				the_posts_pagination( array(
					'prev_text'          => seasaltpress_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'seasaltpress' ) . '</span>',
					'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'seasaltpress' ) . '</span>' . seasaltpress_get_svg( array( 'icon' => 'arrow-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'seasaltpress' ) . ' </span>',
				) );

				echo '</div>';

			else : ?>
			<div class="content-column">
				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'seasaltpress' ); ?></p>
				<?php
				get_search_form();
				echo '</div>';
				endif;
				?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>


<?php get_footer();
