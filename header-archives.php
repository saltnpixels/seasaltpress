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
<header class="page-header">
	<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'seasaltpress' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
</header><!-- .page-header -->

<?php  break; ?>


<?php
//when blog is not the front page.
case (is_home() && ! is_front_page() ):
?>
<header>
	<h1 class="page-title"><?php single_post_title(); ?></h1>
</header> 

<?php break; ?>


<?php case is_front_page(): //if blog is front page  ?>
<header>
	
</header>




<?php
	break;
endswitch;