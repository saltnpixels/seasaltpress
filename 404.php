<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class="error-404 not-found">
				<header class="page-header">
					<div class="header-content">
						<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'seasaltpress' ); ?></h1>
					</div>
				</header><!-- .page-header -->
				
				
				<div class="content-column">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'seasaltpress' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .content-column -->
			</div><!-- .error-404 -->
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
