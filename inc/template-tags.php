<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
* @package Sea_Salt_Press
 * @since 1.0
 */

if( ! function_exists( 'seasaltpress_posted_by') ):
/*
 * Prints the author image with his name.
*/
function seasaltpress_posted_by(){
	$author_id = get_the_author_meta( 'ID' );
	$author_link = esc_url( get_author_posts_url( $author_id ) );
	$author_image = '<a href="' . $author_link . '" class="author-avatar">' . get_avatar( $author_id, 50) . '</a>';
	$author_name = sprintf( __('%s by %s', 'seasaltpress'), '<a href="' . $author_link . '" class="author-name byline fn n"><span>', '</span>' . get_the_author() . '</a>');
	$author_description = '<div class="author-description">' .  get_the_author_meta( 'description' ) . '</div>';
	
	
	return '<div class="posted-by">' . $author_image . '<div class="author-info">' . $author_name . $author_description . '</div></div>';

}
endif;


if ( ! function_exists( 'seasaltpress_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function seasaltpress_posted_on() {


	// Finally, let's write all of this to the page.
	echo '<div class="posted-on">' . seasaltpress_time_link() . '</div>';
}
endif;


if ( ! function_exists( 'seasaltpress_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function seasaltpress_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf(
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'seasaltpress' ),
		'<a class="entry-date" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;


if ( ! function_exists( 'seasaltpress_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function seasaltpress_cats_tags() {

	/* translators: used between list items, there is a space after the comma */
	$separate_meta = __( ', ', 'seasaltpress' );

	// Get Categories for posts.
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.
	$tags_list = get_the_tag_list( '', $separate_meta );

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	if ( ( ( seasaltpress_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<div class="cats-tags-meta">';

			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list && seasaltpress_categorized_blog() ) || $tags_list ) {
					echo '<div class="cats-tags-links">';

						// Make sure there's more than one category before displaying.
						if ( $categories_list && seasaltpress_categorized_blog() ) {
							echo '<span class="cat-links"><span class="screen-reader-text">' . __( 'Categories', 'seasaltpress' ) . '</span>' . $categories_list . '</span>';
						}
						
						if( $categories_list && seasaltpress_categorized_blog() && $tags_list ){
							echo '<span class="cats-tags-sep">|</span>';
						}

						if ( $tags_list ) {
							echo '<span class="tag-links"><span class="screen-reader-text">' . __( 'Tags', 'seasaltpress' ) . '</span>' . $tags_list . '</span>';
						}

					echo '</div>';
				}
			}


		echo '</div> <!-- .cats-tags-meta -->';
	}
}
endif;



if ( ! function_exists( 'seasaltpress_comment_link' ) ) :
/**
 * Returns the comment link with icon for comments as well as comment or comments if wanted. 
 */
function seasaltpress_comment_link($comment_string = false){
 $num_comments = get_comments_number(); // get_comments_number returns only a numeric value

	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			$num_comments = '';
			$comments = __('No Comments');
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __(' Comments');
		} else {
			$comments = __('1 Comment');
		}
		
		if( $comment_string ){
			$write_comments = '<a class="comment-link" href="' . get_comments_link() .'">'. seasaltpress_get_svg( array('icon'=>'comments') ) . ' ' .  $comments . '</a>';
		}
		else{
			$write_comments = '<a class="comment-link" href="' . get_comments_link() .'">'. seasaltpress_get_svg( array('icon'=>'comments') ) . ' ' .  $num_comments . '</a>';
		}
		
		return $write_comments;
	} 
	return;
}
endif;




if ( ! function_exists( 'seasaltpress_edit_link' ) ) :
/**
 * Returns an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 */
function seasaltpress_edit_link() {

	$link = edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'seasaltpress' ),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);

	return $link;
}
endif;



/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function seasaltpress_categorized_blog() {
	$category_count = get_transient( 'seasaltpress_categories' );

	if ( false === $category_count ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$category_count = count( $categories );

		set_transient( 'seasaltpress_categories', $category_count );
	}

	return $category_count > 1;
}


/**
 * Flush out the transients used in seasaltpress_categorized_blog.
 */
function seasaltpress_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'seasaltpress_categories' );
}
add_action( 'edit_category', 'seasaltpress_category_transient_flusher' );
add_action( 'save_post',     'seasaltpress_category_transient_flusher' );
