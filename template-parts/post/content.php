<?php
/**
 * Template part for displaying posts
 * if using sidebar lef tor right, the article gets a max-width of 730 or $content-column
 * on regular straight down pages, entry-content gets $content-column
 * this is done on layout.scss
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sea_Salt_Press
 * @since 1.0
 * @version 1.0
 */

$post_type = get_post_type();
$id        = get_the_ID();
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<?php if ( is_single() ) : ?>

		<header class="entry-header">

			<?php if ( has_post_thumbnail() ): ?>
				<div class="featured-image">
					<?php the_post_thumbnail( 'seasaltpress-featured-image', array( 'class' => 'header-image' ) ); ?>
				</div>
			<?php endif; ?>

			<?php
			$replace_header       = get_post_meta( $id, 'seasaltpress_replace_header', true );
			$extra_header_content = get_post_meta( get_the_ID(), 'seasaltpress_add_to_header', true );
			?>

			<div class="header-content">
				<?php if ( ! $replace_header ) { ?>
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<?php
					if ( $extra_header_content != '' ) :
						?>
						<div class="header-extra-content">
							<?php echo do_shortcode( $extra_header_content ); ?>
						</div>
					<?php endif; ?>
				<?php } else { //if replacing the header we only show the extra header content.
					echo do_shortcode( $extra_header_content );
				}
				?>

			</div><!-- .header-content -->
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'seasaltpress' ),
				get_the_title()
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links">' . __( 'Pages:', 'seasaltpress' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );
			?>
		</div><!-- .entry-content -->


	<?php endif; ?>



	<?php ////////////////////////////////////////////// ?>


	<?php if ( ! is_single() ): ?>

		<header class="entry-header">
			<?php if ( has_post_thumbnail() ): ?>
				<a href="<?php the_permalink(); ?>" class="featured-image">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'header-image' ) ); ?>
				</a>
			<?php endif; ?>

			<?php seasaltpress_cats_tags(); ?>

			<div class="header-content">
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</div>
		</header>

		<div class="entry-content">
			<?php
			if ( has_excerpt() ) {
				the_excerpt();
			} else {

				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Read More<span class="screen-reader-text"> "%s"</span>', 'seasaltpress' ),
					get_the_title()
				) );
			}

			?>
			<?php
			echo seasaltpress_posted_by();
			?>
		</div><!-- .entry-content -->

		<div class="entry-meta">
			<?php echo seasaltpress_posted_on(); ?>
			<?php echo seasaltpress_comment_link(); ?>
		</div>

	<?php endif; //end if not single ?>


</article><!-- #post-## -->


