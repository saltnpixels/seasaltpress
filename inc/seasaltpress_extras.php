<?php
	
	
/**
 * Sea Salt Press extra functions and filters
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
 * @since 1.0
 */
 




/**
 * output_inline_svg function.
 * Outputs inline svg logo when using customizer or outputting theme logo using get_custom_logo
 * @access public
 * @param mixed $html
 * @return void
 */
function seasaltpress_output_inline_svg($html) {
	$logo_id = get_theme_mod( 'custom_logo' );
	
  if( get_post_mime_type($logo_id) == 'image/svg+xml' ){
	  $image = get_attached_file($logo_id);
		$html = preg_replace("/<img[^>]+\>/i", file_get_contents($image) , $html); 	  
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
function admin_bar_color_dev_site(){
	if( strpos(home_url(), '.dev') !== false || strpos(home_url(), 'staging.') !== false){
		echo '<style>
						body #wpadminbar{ background: #156288; }
						</style>';
	}
}

add_action('wp_head', 'admin_bar_color_dev_site');
add_action('admin_head', 'admin_bar_color_dev_site');




/*
 * [logo] 
 * outputs logo in link in either h1 or p. Also output svg logo inline
*/
function seasaltpress_logo( $return_image_url = false){
	
	if ( has_custom_logo() ) {
				
		$logo = get_custom_logo();
	}
		
 else { //no theme mod found. Get site title instead.
 	$no_image = true;
 	$logo = '<div class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name') .'
		</a></div>
		';

	}//theme mod 
		
	//now we output logo_output or both on customier or url for login page
		//if we are in the customizer preview get both.
		if( is_customize_preview() ){
	
			return '<div class="site-logo"><h1>' . get_custom_logo() . '<div class="site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name') .'
				</a></div>' . '</h1></div>';
		}
		
	//return logo url for use in css (like on login page) or something other than actual hmtl output of logo. Not inline though... You can use javascript to turn into svg...
		if( $return_image_url ){
			return  $no_image == true ? false : wp_get_attachment_url($logo_id);
		}
		

		
		if(is_front_page() && ! has_custom_logo() ){
			return '<div class="site-logo"><h1>' . $logo . '</h1></div>';
		}
		
		else{
			return '<div class="site-logo"><p>' . $logo . '</p></div>';
		}
		
}


/*--------------------------------------------------------------
# ADMIN ACCESS AND ADMIN BAR VISIBILITY
--------------------------------------------------------------*/

/**
 * Disable admin bar for everyone but admins
 *
 */
function disable_admin_bar() { 
	if( ! current_user_can('manage_options') ){
		add_filter('show_admin_bar', '__return_false');	
	}
}
add_action( 'after_setup_theme', 'disable_admin_bar' );
 
 
 /**
 * Redirect back to homepage and not allow access to WP Admin. Except adminis and ajax
 */
function redirect_admin(){
	if( ! current_user_can('manage_options') && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ){
		wp_redirect( home_url() );
		exit;		
	}
}
add_action( 'admin_init', 'redirect_admin' );


/**
 * Disable rich editor for pages using the blank template.
 * to do: may not work. check and test
 */

add_filter( 'user_can_richedit', 'disable_rich_edit' );
function disable_rich_edit( $can ) 
{
    global $post;

    if ( get_page_template_slug( $post->ID ) == 'page-blank.php' )
        return false;

    return $can;
}

/**
 * Login page logo points to home page
 */
function the_url( $url ) {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'the_url' );


/**
 * Put logo on login page
 */
function my_login_stylesheet() {
	
	if( seasaltpress_logo( true ) ){
	?>
	<style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('<?php echo seasaltpress_logo( true ); ?>');
            padding-bottom: 30px;
        }
    </style>
 <?php
	   }
	    
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' );
    //wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/style-login.js' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );




/**
 * Ovveride comment section comment. Now you can change html and css how you want!
 Taken from class-walker-comment.php html5 comment walker
 */

//html5 comment
function seasaltpress_comments_callback($comment, $args, $depth){
 
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
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
 * @param int $id Optional. Post ID.
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool $stripteaser Optional. Strip teaser content before the more text. Default is false.
 */
function seasaltpress_the_content( $post_id=0, $more_link_text = null, $stripteaser = false ){
    $post = get_post($post_id);
    setup_postdata( $post, $more_link_text, $stripteaser );
    the_content();
    wp_reset_postdata( $post );
}


/**
 * Check if this page is being used as an archive header.
 * return true
 * if $return_state is true return the actual state to be used in admin on list of pages
 */
function seasaltpress_is_page_archive_header( $post_id, $return_state = false ){
	
	//get all post types that have an archive page and get the main post type post.
	$seasaltpress_post_types = get_post_types(array('_builtin'=>false, 'has_archive'=>true), 'objects');
	$seasaltpress_post_types[] = get_post_type_object('post'); //add this built in object only.
	
	if ( 'page' == get_post_type( $post_id ) && ! empty($seasaltpress_post_types) ) {
	  
	  //foreach post type, if that post type has a theme mod associated with it and that id is equal to this page, return true
	    foreach( $seasaltpress_post_types as $key => $post_type ){
		    if( (int) get_theme_mod( 'seasaltpress_archive_header_' . $post_type->name ) == $post_id ){
		    	return $return_state ?  __('Archive ', 'seasaltpress') . $post_type->labels->singular_name . __(' Header', 'seasaltpress') : true;
		    	break;
	    	} //if theme mod with this post type has this page
	    } //foreach 
    } //if page
    return false; 
}

//add state label to a page used as an archive header
add_filter('display_post_states', 'custom_post_states', 10, 2);
function custom_post_states( $states, $post ) { 

    $state = seasaltpress_is_page_archive_header( $post->ID, true );
    
    if( $state ){
	    $states[] = $state;
    }

    return $states;
} 



/**
 * SEASALTPRESS THEME OPTIONS META BOXES
 *
 */
 
//default meta boxes
add_filter('seasaltpress_add_meta', 'seasaltpress_default_metas');
function seasaltpress_default_metas( $meta ){
	$meta[] = array(
		array(
			'id' => 'seasaltpress_extra_scripts',
			'label' => __('Javascript', 'seasaltpress'),
			'type' => 'textarea',
			'description' => __('Add js', 'seasaltpress')
		),
		array(
			'id' => 'seasaltpress_extra_styles',
			'label' => __('CSS Styles', 'seasaltpress'),
			'type' => 'textarea',
			'description' => __('Add styles', 'seasaltpress')
		),
		array(
			'id' => 'seasaltpress_add_to_header',
			'label' => __('Add To Header', 'seasaltpress'),
			'type' => 'editor',
			'description' => __('Add text to header area', 'seasaltpress'),
			'active_callback' => 'seasaltpress_is_page_archive_header'
		),
		array(
			'id' => 'seasaltpress_replace_header',
			'label' => __('Replace Template Header', 'seasaltpress'),
			'type' => 'checkbox',
			'description' => __('Use the content above to Completely replace the header. Remember to include a title.', 'seasaltpress')
		),
		
		//add more metas here
		
		
	);
	return $meta;	
}



/**
 * Based on WordPress Meta Box Generator at http://goo.gl/8nwllb
 * Changed by Shamai to include WP Editor and use easier names and show images on uploader. Can also now add your own metas
 */
class Rational_Meta_Box {
	
	//defualt types. change with add_filter('seasaltpress_meta_box_post_types', 'array return callback');
	private $screens = array(
		'post',
		'page',
	);
	//add to these with with add_filter('seasaltpress_add_meta', 'array return callback');
	private $fields = array();

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 */
	public function __construct() {
		$metas = apply_filters('seasaltpress_add_meta', $this->fields); 

		foreach( $metas as $meta ){
			foreach($meta as $custom_field){
				$this->fields[] = $custom_field;
			}
		}

		$this->screens = apply_filters('seasaltpress_meta_box_post_types', $this->screens);
		 
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
				
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 * Goes through screens (post types) and adds the meta box.
	 */
	public function add_meta_boxes() {
		
				
		foreach ( $this->screens as $screen ) {
			add_meta_box(
				'sea-salt-press-options',
				__( 'Sea Salt Press Options', 'seasaltpress' ),
				array( $this, 'add_meta_box_callback' ),
				$screen,
				'advanced',
				'default'
			);
		}
	}
	

	

	/**
	 * Generates the HTML for the meta box
	 * 
	 * @param object $post WordPress post object
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'sea_salt_press_options_data', 'sea_salt_press_options_nonce' );
		$this->generate_fields( $post );
	}

	/**
	 * Hooks into WordPress' admin_footer function.
	 * Adds scripts for media uploader.
	 */
	public function admin_footer() {
		
		?><script>
			// https://codestag.com/how-to-use-wordpress-3-5-media-uploader-in-theme-options/
			jQuery(document).ready(function($){
				if ( typeof wp.media !== 'undefined' ) {
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
					$('.rational-metabox-media').click(function(e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', ''); //get the hidden id without button on it
						_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								$("#"+id).val(attachment.id);
								$('#'+id+'_image').attr('src', attachment.url); //added by seasaltpress
							} else {
								return _orig_send_attachment.apply( this, [props, attachment] );
							};
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.add_media').on('click', function(){
						_custom_media = false;
					});
					
					//added ability to delete image
					$('.delete-media').click( function(e){
						var id = $(this).attr('id').replace('_delete', ''); //get the hidden id without button on it
						$('#'+id).val('');
						$('#'+id+'_image').attr('src', ''); //added by seasaltpress
					});	
				}
				
			});
		</script><?php
	}

	/**
	 * Generates the field's HTML for the meta box.
	 */
	public function generate_fields( $post ) {
		$output = '';
		echo '<table class="form-table"><tbody>';
		$post_type = get_post_type($post);
			
		if( ! is_array($this->fields) )
			return;	
		
		foreach ( $this->fields as $field ) {
			if( isset($field['post_type']) && is_array($field['post_type']) && ! in_array($post_type, $field['post_type']) )
				continue;
				
			if( isset($field['active_callback']) && $field['active_callback']($post->ID) ){
				continue;
			}
					
			$wp_editor = false; //set to false tilla n editor is called
			$label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, $field['id'], true );
			
			switch ( $field['type'] ) {
				case 'media':
					$image_url = $db_value == '' ? '' : wp_get_attachment_url( $db_value );
					$input = sprintf(
						'<input type="hidden" name="%s" id="%s" val="%s" /><input style="vertical-align: top;" class="button rational-metabox-media" id="%s_button" name="%s_button" type="button" value="Upload" /><img id="%s_image" style="vertical-align: top; margin-left: 10px; margin-right: 10px; "  width="75px" src="%s"><input class="button delete-media" type="button" name="%s_delete" id="%s_delete" value="Delete" /><p class="description">%s</p>',
						$field['id'],
						$field['id'],
						$db_value,
						$field['id'],
						$field['id'],
						$field['id'],
						$image_url,
						$field['id'],
						$field['id'],
						$field['description']	
						
					);
					break;
				case 'textarea':
					$input = sprintf(
						'<textarea class="large-text" id="%s" name="%s" rows="10">%s</textarea><p class="description">%s</p>',
						$field['id'],
						$field['id'],
						$db_value,
						$field['description']
					);
					break;
				case 'editor':
					$wp_editor = true; 
					$input = '';
					break;
				case 'checkbox':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="checkbox" value="1"> <span class="description">%s</span>',
						$db_value === '1' ? 'checked' : '',
						$field['id'],
						$field['id'],
						$field['description']
					);
					break;
				case 'radio':
					$input = '<fieldset>';
					$input .= '<legend class="screen-reader-text">' . $field['label'] . '</legend>';
					$i = 0;
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<label><input %s id="%s" name="%s" type="radio" value="%s"> %s</label>%s',
							$db_value === $field_value ? 'checked' : '',
							$field['id'],
							$field['id'],
							$field_value,
							$value,
							$i < count( $field['options'] ) - 1 ? '<br>' : ''
						);
						$i++;
					}
					$input .= '</fieldset>';
					$input.= '<p class="description">' . $field['description'] .'</p>';
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$field['id'],
						$field['id']
					);
					foreach ( $field['options'] as $key => $value ) {
						$field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							$field_value,
							$value
						);
					}
					$input .= '</select>';
					$input.= '<p class="description">' . $field['description'] .'</p>';
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
					$input.= '<p class="description">' . $field['description'] .'</p>';
			}
			
			//cannot be in switch, it outputs right away
			if( $wp_editor){
				echo '<tr><th scope="row">' . $label . '</th><td>';
			wp_editor( $db_value, $field['id'], array( 'media_buttons' => true ) );
			echo '<p class="description">' . $field['description'] . '</p>';
			echo '</td></tr>'; 
			
			}
			else{
				echo $this->row_format( $label, $input);
			}
		}
		
		
		echo '</tbody></table>';
	}

	/**
	 * Generates the HTML for table rows.
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
		
	}
	/**
	 * Hooks into WordPress' save_post function
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['sea_salt_press_options_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sea_salt_press_options_nonce'];
		if ( !wp_verify_nonce( $nonce, 'sea_salt_press_options_data' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
			
			// check if there was a multisite switch before
   if ( is_multisite() && ms_is_switched() ) {
      return $post_id;
   }
  

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
					case 'media':
						$_POST[ $field['id'] ] = absint( $_POST[ $field['id'] ] );
						
						break;
					 case 'editor': //kses_post seems to loses any styling or anything which is annoying...
					 	$_POST[ $field['id'] ] = $_POST[ $field['id'] ] ;
					 	break;
				}
				update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $field['id'], '0' );
			}
		}
	}
}
new Rational_Meta_Box;
