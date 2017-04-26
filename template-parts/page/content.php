<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
 * @since 1.0
 * @version 1.0
 */
 

$post_type = get_post_type();
$id = get_the_ID();

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if( is_page() ) : ?>

	<header class="entry-header">
		
		<?php if( has_post_thumbnail() ): ?>
		<div class="featured-image">
			<?php the_post_thumbnail( 'seasaltpress-featured-image', array('class'=>'header-image')); ?>
		</div>
		<?php endif; ?>
		
		<?php 
			$replace_header = get_post_meta( $id, 'seasaltpress_replace_header', true );
			$extra_header_content = get_post_meta( get_the_ID(), 'seasaltpress_add_to_header', true);
		?>
		
			<div class="header-content">
		<?php	if( ! $replace_header ){ ?>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			
			<?php 
					if( $extra_header_content != '' ) : 
				?>
				<div class="header-extra-content">
						<?php echo do_shortcode($extra_header_content); ?>
				</div>
			<?php endif; ?>
			
		<?php }
			
			else{
				echo do_shortcode($extra_header_content);
			}
		?>
				
		</div><!-- .header-content -->
	</header><!-- .entry-header -->
	
	
	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'seasaltpress' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->


<?php endif; ?>



<?php ////////////////////////////////////////////// ?>


<?php if( ! is_page() ): ?>

	<header class="entry-header">
		<?php if( has_post_thumbnail() ): ?>
		<a href="<?php the_permalink(); ?>" class="featured-image">
			<?php the_post_thumbnail( 'seasaltpress-featured-image', array('class'=>'header-image')); ?>
		</a>
		<?php endif; ?>
		
		<div class="header-content">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		</div>
	</header>

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Read More<span class="screen-reader-text"> "%s"</span>', 'seasaltpress' ),
				get_the_title()
			) );


		?>
	</div><!-- .entry-content -->
	

<?php endif; ?>

</article><!-- #post-## -->
