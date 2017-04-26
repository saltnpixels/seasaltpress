<?php
	
/**
 * Adds a header to the top of an archive post type or search, be it post or anything else.
 * These are all outside the loop 
 * 
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sea_salt_press
 */


switch(true):



case is_search():
?>
<header class="archive-header">
	<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'snp' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
</header><!-- .page-header -->

<?php  break; ?>


<?php
//when blog is not the front page.
case (is_home() && ! is_front_page() ):
?>
<header class="archive-header">
	<div class="col center-text">
		<h1 class="page-title">	<?php  echo get_the_title( get_option('page_for_posts', true) ); // no good loses html on title single_post_title(); ?></h1>
		<div class="filtering">
			<div class="dropdown">
			<?php
				wp_list_categories(); 
			?>
			</div>
			
			<div class="dropdown">
			<?php
				 $args = array(
				 'show_option_none' => 'No Tags',	 
				 'taxonomy' => 'post_tag',
				 'title_li' => __( 'Tags' )
					 );
				wp_list_categories($args); 
			?>
			</div>
			
		</div>
	</div>
</header> 



<?php break; 
	
	case is_post_type_archive(): ?>
	
	<header class="archive-header">
			<div class="col center-text">
			<h1 class="page-title">	<?php  echo post_type_archive_title(); // no good loses html on title single_post_title(); ?></h1>
			<?php if(is_post_type_archive('snp_portfolio')){
				echo '<div class="filtering"><h2 class="center-text"><a href="http://dribbble.com/saltnpixels/" target="_blank" class="link">Check out more work on <i class="fa fa-dribbble"></i> Dribble</a></h2></div>';
			}?>
			</div>
		</header>
		
	
	
	<?php
	break;
	
	default: ?>
		 <header class="archive-header">
		<div class="col center-text wrap">
			
				  <?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				  
			</div>
		</header> 
	</header>
	
	<?php 
		break;
endswitch;