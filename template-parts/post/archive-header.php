<?php
/**
 * Template for Post Archive header
 */
?>

<?php
$post_type = get_post_type(); //archive post type, NOT the page post type

$archive_header = new WP_Query(array(
	'post_status' => 'publish',
	'post_type' => 'page',
	'p' => $archive_header_page,
	'no_found_rows' => true
));
//loop
if ( $archive_header->have_posts() ) : ?>
	<?php while ( $archive_header->have_posts() ) : $archive_header->the_post(); ?>

		<?php
		$id = get_the_ID();


		echo '<script>' . get_post_meta($id, 'seasaltpress_extra_scripts', true) . '</script>';
		echo '<style>' . get_post_meta($id, 'seasaltpress_extra_styles', true) . '</style>';

		?>

        <header id="post-<?php the_ID(); ?>" <?php post_class('page-header'); ?>>
			<?php if( has_post_thumbnail() ): ?>
                <div class="featured-image">
					<?php the_post_thumbnail( 'seasaltpress-featured-image', array('class'=>'header-image')); ?>
                </div>
			<?php endif; ?>

            <div class="header-content">
				<?php
				$replace_header = get_post_meta( $id, 'seasaltpress_replace_header', true );
				if( ! $replace_header ){
					if ( ( is_home() || is_post_type_archive() ) && ! is_front_page() ){
						the_title( '<h1 class="page-title">', '</h1>' );
					}
					else{
						the_title( '<h2 class="page-title">', '</h2>' );
					}
					?>
                    <div class="header-extra-content">
						<?php the_content(); ?>
                    </div>
				<?php }
				else{
					the_content();
				}
				?>
            </div><!-- .header-content -->
			<?php echo seasaltpress_edit_link(); ?>

        </header>

	<?php endwhile; ?>

<?php endif; ?>


<?php wp_reset_postdata(); ?>