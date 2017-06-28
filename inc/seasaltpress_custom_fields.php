<?php

/**
 * SEASALTPRESS THEME OPTIONS META BOXES
 *
 */
/**
 * Add custom styles and scripts to single and page templates from the meta boxes
 */
function seasaltpress_add_extra_styles_and_scripts() {
	if ( is_single() || is_page() ) {
		global $post;
		echo '<script>' . get_post_meta( $post->ID, 'seasaltpress_extra_scripts', true ) . '</script>';
		echo '<style>' . get_post_meta( $post->ID, 'seasaltpress_extra_styles', true ) . '</style>';
	}
}
add_action( 'wp_head', 'seasaltpress_add_extra_styles_and_scripts' );


//default meta boxes
add_filter( 'seasaltpress_add_meta', 'seasaltpress_default_metas' );
function seasaltpress_default_metas( $meta ) {
	$meta[] = array(
		array(
			'id'          => 'seasaltpress_extra_scripts',
			'label'       => __( 'Javascript', 'seasaltpress' ),
			'type'        => 'textarea',
			'description' => __( 'Add js', 'seasaltpress' )
		),
		array(
			'id'          => 'seasaltpress_extra_styles',
			'label'       => __( 'CSS Styles', 'seasaltpress' ),
			'type'        => 'textarea',
			'description' => __( 'Add styles', 'seasaltpress' )
		),
		array(
			'id'              => 'seasaltpress_add_to_header',
			'label'           => __( 'Add To Header', 'seasaltpress' ),
			'type'            => 'editor',
			'description'     => __( 'Add text to header area', 'seasaltpress' ),
			'active_callback' => 'seasaltpress_is_page_archive_header'
		),
		array(
			'id'          => 'seasaltpress_replace_header',
			'label'       => __( 'Replace Template Header', 'seasaltpress' ),
			'type'        => 'checkbox',
			'description' => __( 'Use the content above to Completely replace the header. Remember to include a title.', 'seasaltpress' )
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
		$metas = apply_filters( 'seasaltpress_add_meta', $this->fields );

		foreach ( $metas as $meta ) {
			foreach ( $meta as $custom_field ) {
				$this->fields[] = $custom_field;
			}
		}

		$this->screens = apply_filters( 'seasaltpress_meta_box_post_types', $this->screens );

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


		?>
		<script>
            // https://codestag.com/how-to-use-wordpress-3-5-media-uploader-in-theme-options/
            jQuery(document).ready(function ($) {

                if (typeof wp.media !== 'undefined' && typeof wp.media.editor !== 'undefined') {
                    var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                    $('.rational-metabox-media').click(function (e) {
                        var send_attachment_bkp = wp.media.editor.send.attachment;
                        var button = $(this);
                        var id = button.attr('id').replace('_button', ''); //get the hidden id without button on it
                        _custom_media = true;
                        wp.media.editor.send.attachment = function (props, attachment) {
                            if (_custom_media) {
                                $("#" + id).val(attachment.id);
                                $('#' + id + '_image').attr('src', attachment.url); //added by seasaltpress
                            } else {
                                return _orig_send_attachment.apply(this, [props, attachment]);
                            }
                            ;
                        }
                        wp.media.editor.open(button);
                        return false;
                    });
                    $('.add_media').on('click', function () {
                        _custom_media = false;
                    });

                    //added ability to delete image
                    $('.delete-media').click(function (e) {
                        var id = $(this).attr('id').replace('_delete', ''); //get the hidden id without button on it
                        $('#' + id).val('');
                        $('#' + id + '_image').attr('src', ''); //added by seasaltpress
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
		$post_type = get_post_type( $post );

		if ( ! is_array( $this->fields ) ) {
			return;
		}

		foreach ( $this->fields as $field ) {
			if ( isset( $field['post_type'] ) && is_array( $field['post_type'] ) && ! in_array( $post_type, $field['post_type'] ) ) {
				continue;
			}

			if ( isset( $field['active_callback'] ) && $field['active_callback']( $post->ID ) ) {
				continue;
			}

			$wp_editor = false; //set to false tilla n editor is called
			$label     = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value  = get_post_meta( $post->ID, $field['id'], true );

			switch ( $field['type'] ) {
				case 'media':
					$image_url = $db_value == '' ? '' : wp_get_attachment_url( $db_value );
					$input     = sprintf(
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
					$input     = '';
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
					$i     = 0;
					foreach ( $field['options'] as $key => $value ) {
						$field_value = ! is_numeric( $key ) ? $key : $value;
						$input       .= sprintf(
							'<label><input %s id="%s" name="%s" type="radio" value="%s"> %s</label>%s',
							$db_value === $field_value ? 'checked' : '',
							$field['id'],
							$field['id'],
							$field_value,
							$value,
							$i < count( $field['options'] ) - 1 ? '<br>' : ''
						);
						$i ++;
					}
					$input .= '</fieldset>';
					$input .= '<p class="description">' . $field['description'] . '</p>';
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$field['id'],
						$field['id']
					);
					foreach ( $field['options'] as $key => $value ) {
						$field_value = ! is_numeric( $key ) ? $key : $value;
						$input       .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							$field_value,
							$value
						);
					}
					$input .= '</select>';
					$input .= '<p class="description">' . $field['description'] . '</p>';
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
					$input .= '<p class="description">' . $field['description'] . '</p>';
			}

			//cannot be in switch, it outputs right away
			if ( $wp_editor ) {
				echo '<tr><th scope="row">' . $label . '</th><td>';
				wp_editor( $db_value, $field['id'], array( 'media_buttons' => true ) );
				echo '<p class="description">' . $field['description'] . '</p>';
				echo '</td></tr>';

			} else {
				echo $this->row_format( $label, $input );
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
		if ( ! isset( $_POST['sea_salt_press_options_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['sea_salt_press_options_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'sea_salt_press_options_data' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

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
						$_POST[ $field['id'] ] = $_POST[ $field['id'] ];
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