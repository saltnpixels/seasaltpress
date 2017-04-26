<?php
/**
 * Template part for displaying posts on archive pages blog and categories and tags.
 * to show excerpts on the index page follow content-search
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */

?>
 <div class="col">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<a href="<?php the_permalink(); ?>">
		<?php
				the_post_thumbnail();
				?>
		</a>
				<?php
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php snp_posted_on();  //date and author ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->


	<div class="entry-content">
		<?php
			the_excerpt();
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php snp_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
 </div>