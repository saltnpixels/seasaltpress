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

<div class="portfolio-container">
	<header class="entry-header">
		<?php
			the_title( '<h2 class="entry-title">', '</h2>' );
			snp_entry_footer(); 
			
		?>
	</header>

  <div class="entry-content">
	 
		<?php
				the_post_thumbnail();
				?>
	
  </div>
  
	<footer class="entry-footer">
		<?php $website = get_post_meta(get_the_ID(), 'website', true);
			$pod = pods('snp_portfolio', get_the_ID());
			
				$bigger_image = $pod->display('pop_up_image');
				
				if($website !== ''){
			 ?>
		<a target="_blank" href="<?php echo $website; ?>">
			<i class="fa fa-globe"></i>
		</a>
		<?php }
			if($bigger_image){
					?>
		
			<a id="item-<?php the_ID(); ?>" class="fancybox" rel="gallery" href="<?php echo $bigger_image; ?>">
			<i class="fa fa-expand"></i>
		</a>
    <?php }  ?>
	</footer><!-- .entry-footer -->
 </div>
 
</article><!-- #post-## -->
 </div>