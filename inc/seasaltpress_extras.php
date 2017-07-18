<?php


/**
 * Sea Salt Press extra functions and filters
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Sea_Salt_Press
 * @since 1.0
 */


function iodine_is_active() {
	if ( is_plugin_active( 'iodine/iodine.php' ) ) {
		return false;
	}
	?>
    <div class="notice notice-error is-dismissible">
        <p>
            <a target="_blank"
               href="https://github.com/saltnpixels/Iodine"> <?php _e( 'This plugin works best with iodine installed!!', 'seasaltpress' ); ?></a>
        </p>
    </div>
	<?php
}

add_action( 'admin_notices', 'iodine_is_active' );


/**
 * output_inline_svg function.
 * Outputs inline svg logo when using customizer or outputting theme logo using get_custom_logo
 * @access public
 *
 * @param mixed $html
 *
 * @return void
 */
function seasaltpress_output_inline_svg( $html ) {
	$logo_id = get_theme_mod( 'custom_logo' );

	if ( get_post_mime_type( $logo_id ) == 'image/svg+xml' ) {
		$image = get_attached_file( $logo_id );
		$html  = preg_replace( "/<img[^>]+\>/i", file_get_contents( $image ), $html );
	}

	return $html;
}

add_filter( 'get_custom_logo', 'seasaltpress_output_inline_svg' );


/**
 * admin_bar_color_dev_site function.
 * So you can tell if your wokring on dev site or staging site by checking if admin bar is blue or not. Blue means staging
 * @access public
 * @return void
 */
function admin_bar_color_dev_site() {
	if ( strpos( home_url(), '.dev' ) !== false || strpos( home_url(), 'staging.' ) !== false ) {
		echo '<style>
						body #wpadminbar{ background: #156288; }
						</style>';
	}
}

add_action( 'wp_head', 'admin_bar_color_dev_site' );
add_action( 'admin_head', 'admin_bar_color_dev_site' );


/*--------------------------------------------------------------
# Logo stuff
--------------------------------------------------------------*/

/**
 * seasaltpress_logo function.
 *
 * @access public
 *
 * @param bool if $return_image_url instead if this is true
 *
 * @return returns string for logo with h1 or p based on page.
 */
function seasaltpress_logo() {

	if ( has_custom_logo() ) {

		$logo = get_custom_logo();
	} else { //no theme mod found. Get site title instead.
		$no_image = true;
		$logo     = '<div class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '
		</a></div>
		';

	}//theme mod 

	//now we output logo_output or both on customier or url for login page
	//if we are in the customizer preview get both.
	if ( is_customize_preview() ) {

		return '<div class="site-logo"><h1>' . get_custom_logo() . '<div class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '
				</a></div>' . '</h1></div>';
	}


	if ( is_front_page() && ! has_custom_logo() ) {
		return '<div class="site-logo"><h1>' . $logo . '</h1></div>';
	} else {
		return '<div class="site-logo"><p>' . $logo . '</p></div>';
	}

}


/**
 * Add logo to login page inline. Not with CSS.
 */
function the_login_logo( $message ) {
	if ( empty( $message ) ) {
		return seasaltpress_logo();
	} else {
		return seasaltpress_logo() . $message;
	}
}

add_filter( 'login_message', 'the_login_logo' );


/**
 * Hide wordpress logo and make current logo centered.
 */
function my_login_stylesheet() {

	if ( seasaltpress_logo( true ) ) {
		?>
        <style type="text/css">
            body {
                display: flex;
                align-items: center;
            }

            #login h1 a, .login h1 a {
                display: none;
                padding-bottom: 30px;
            }

            body .custom-logo-link {
                margin: 0 auto 30px;
                display: block;
                text-align: center;
            }

            .custom-logo-link svg {
                max-width: 100%;
            }

        </style>
		<?php
	}

	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' );
}

add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );


/**
 * Login page logo points to home page
 */
function the_url( $url ) {
	return get_bloginfo( 'url' );
}

add_filter( 'login_headerurl', 'the_url' );


/*--------------------------------------------------------------
# ADMIN ACCESS AND ADMIN BAR VISIBILITY
--------------------------------------------------------------*/

/**
 * Disable admin bar for everyone but admins
 *
 */
function disable_admin_bar() {
	if ( ! current_user_can( 'manage_options' ) ) {
		add_filter( 'show_admin_bar', '__return_false' );
	}
}

add_action( 'after_setup_theme', 'disable_admin_bar' );


/**
 * Redirect back to homepage and not allow access to WP Admin. Except admins and ajax
 */
function redirect_admin() {
	if ( ! current_user_can( 'manage_options' ) && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

add_action( 'admin_init', 'redirect_admin' );


/**
 * Disable rich editor for pages using the blank template.
 * to do: may not work. check and test
 */

//add_filter( 'user_can_richedit', 'disable_rich_edit' );
function disable_rich_edit( $can ) {
	global $post;

	if ( get_page_template_slug( $post->ID ) == 'page-blank.php' ) {
		return false;
	}

	return $can;
}


/*--------------------------------------------------------------
# Comment override walker
--------------------------------------------------------------*/

/**
 * Ovveride comment section comment. Now you can change html and css how you want!
 * Taken from class-walker-comment.php html5 comment walker
 */

//html5 comment
function seasaltpress_comments_callback( $comment, $args, $depth ) {

	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <footer class="comment-meta">
            <div class="comment-author vcard">
				<?php if ( 0 != $args['avatar_size'] ) {
					echo get_avatar( $comment, $args['avatar_size'] );
				} ?>
            </div><!-- .comment-author -->

            <div class="comment-name-date">
				<?php printf( __( '%s <span class="says">says:</span>' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) ) ); ?>

                <div class="comment-metadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>">
							<?php
							/* translators: 1: comment date, 2: comment time */
							printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
                        </time>
                    </a>
					<?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
                </div><!-- .comment-metadata -->
            </div>

			<?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
			<?php endif; ?>
        </footer><!-- .comment-meta -->

        <div class="comment-content">
			<?php comment_text(); ?>
        </div><!-- .comment-content -->

		<?php
		comment_reply_link( array_merge( $args, array(
			'add_below' => 'div-comment',
			'depth'     => $depth,
			'max_depth' => $args['max_depth'],
			'before'    => '<div class="reply">',
			'after'     => '</div>'
		) ) );
		?>


    </article><!-- .comment-body -->
	<?php
}


/**
 * Display the post content outside loop. Optinally allows post ID to be passed
 * @uses the_content()
 * @link http://stephenharris.info/get-post-content-by-id/
 * @link http://wordpress.stackexchange.com/questions/142957/use-the-content-outside-the-loop
 *
 * @param int $id Optional. Post ID.
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool $stripteaser Optional. Strip teaser content before the more text. Default is false.
 */
function seasaltpress_the_content( $post_id = 0, $more_link_text = null, $stripteaser = false ) {
	$post = get_post( $post_id );
	setup_postdata( $post, $more_link_text, $stripteaser );
	the_content();
	wp_reset_postdata( $post );
}


/**
 * Check if this page is being used as an archive header.
 * return true
 * if $return_state is true return the actual state to be used in admin on list of pages
 */

/**
 * seasaltpress_is_page_archive_header function.
 *
 * @access public
 *
 * @param int $post_id
 * @param bool $return_state (default: false)
 *
 * @return string state label OR true
 */
function seasaltpress_is_page_archive_header( $post_id, $return_state = false ) {

	//get all post types that have an archive page and get the main post type post.
	$seasaltpress_post_types   = get_post_types( array( '_builtin' => false, 'has_archive' => true ), 'objects' );
	$seasaltpress_post_types[] = get_post_type_object( 'post' ); //add this built in object only.

	if ( 'page' == get_post_type( $post_id ) && ! empty( $seasaltpress_post_types ) ) {

		//foreach post type, if that post type has a theme mod associated with it and that id is equal to this page, return true
		foreach ( $seasaltpress_post_types as $key => $post_type ) {
			if ( (int) get_theme_mod( 'seasaltpress_archive_header_' . $post_type->name ) == $post_id ) {
				return $return_state ? __( 'Archive ', 'seasaltpress' ) . $post_type->labels->singular_name . __( ' Header', 'seasaltpress' ) : true;
				break;
			} //if theme mod with this post type has this page
		} //foreach
	} //if page

	return false;
}


//add state label to a page used as an archive header
add_filter( 'display_post_states', 'custom_post_states', 10, 2 );
function custom_post_states( $states, $post ) {

	$state = seasaltpress_is_page_archive_header( $post->ID, true );

	if ( $state ) {
		$states[] = $state;
	}

	return $states;
} 


