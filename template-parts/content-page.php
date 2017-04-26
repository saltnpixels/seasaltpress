<?php
/**
 * Template part for displaying page content. inside loop
 * if using sidebar template the content header is gotten before this, outside loop and above the article and sidebar.
 * for blank page template, no header is gotten and content is wide. content column set to 100% in post and pages.scss
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sea_salt_press
 */

?>

<?php
	echo get_post_meta(get_the_ID(), 'snp_extra_styles', true);
	$show_header_inside_article = false;

	
	
		//all pages you want to have header inside the article. not sidebar page. and not blank page which has no header at all
	if(get_page_template_slug() == '' || get_page_template_slug() == 'page-full-width.php'){
   	$show_header_inside_article = true;
	}
	
	
?>
	
	
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	 
	<?php
   	
   	//if its a regular page, without a sidebar or its full width page template, get the header inside loop 
		if($show_header_inside_article){
		 get_template_part('template-parts/content', 'header');
		 }
	 ?>

	
	
	<div class="entry-content content-column">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'snp' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'snp' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
