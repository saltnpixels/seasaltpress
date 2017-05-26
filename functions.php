<?php


/**
 * Sea Salt Press functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Sea_Salt_Press
 * @since 1.0
 */

/**
 * Sea Salt Press only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


/**
 * Allow upload of svg
 * 
 */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml'; 
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


function svgs_disable_real_mime_check( $data, $file, $filename, $mimes ) {
    $wp_filetype = wp_check_filetype( $filename, $mimes );

    $ext = $wp_filetype['ext'];
    $type = $wp_filetype['type'];
    $proper_filename = $data['proper_filename'];

    return compact( 'ext', 'type', 'proper_filename' );
}
add_filter( 'wp_check_filetype_and_ext', 'svgs_disable_real_mime_check', 10, 4 );



/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function seasaltpress_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/seasaltpress
	 * If you're building a theme based on Sea Salt Press, use a find and replace
	 * to change 'seasaltpress' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'seasaltpress' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'seasaltpress-featured-image', 2000, 1200, true );


		
	/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function seasaltpress_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pwm_content_width', 730 );
}
add_action( 'after_setup_theme', 'seasaltpress_content_width', 0 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'seasaltpress' ),
		'social' => __( 'Social Links Menu', 'seasaltpress' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
/*
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );
*/

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 400,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'editor-style.css', seasaltpress_google_fonts_url() ) );



}
add_action( 'after_setup_theme', 'seasaltpress_setup' );



/**
 * Register custom fonts.
 */
function seasaltpress_google_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'seasaltpress' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();
		
		//add your fonts here into array
		//example: Oswald:400,700
		//use pipe to seperate types: Pangolin|Roboto:300,400 

		$font_families[] = 'Roboto:400,400i,700,700i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}



/**
 * Add preconnect for Google Fonts.
 *
 * @since Sea Salt Press 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function seasaltpress_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'seasaltpress-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'seasaltpress_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
 
 
function seasaltpress_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'seasaltpress' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'seasaltpress' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	

	
//footer widgets and sections. up to 4
		register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'seasaltpress' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add footer widgets here.', 'pwm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );


		register_sidebar( array(
			'name'          => esc_html__( 'Footer 2', 'seasaltpress' ),
			'id'            => 'sidebar-3',
			'description'   => esc_html__( 'Add footer widgets here.', 'pwm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			) );
	

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 3', 'seasaltpress' ),
			'id'            => 'sidebar-4',
			'description'   => esc_html__( 'Add footer widgets here.', 'pwm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			) );
			
		register_sidebar( array(
			'name'          => esc_html__( 'Footer 4', 'seasaltpress' ),
			'id'            => 'sidebar-5',
			'description'   => esc_html__( 'Add footer widgets here.', 'pwm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			) );

}
add_action( 'widgets_init', 'seasaltpress_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Sea Salt Press 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function seasaltpress_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'seasaltpress' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'seasaltpress_excerpt_more' );


/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Sea Salt Press 1.0
 */
function seasaltpress_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'seasaltpress_javascript_detection', 0 );



/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function seasaltpress_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'seasaltpress_pingback_header' );



/**
 * Add custom styles and scripts to single and page templates from the meta boxes
 */
function seasaltpress_add_extra_styles_and_scripts(){
	if( is_single() || is_page() ){
		global $post;
		echo '<script>' . get_post_meta($post->ID, 'seasaltpress_extra_scripts', true) . '</script>';
		echo '<style>' . get_post_meta($post->ID, 'seasaltpress_extra_styles', true) . '</style>';
	}
}
add_action( 'wp_head', 'seasaltpress_add_extra_styles_and_scripts' );



/**
 * Enqueue scripts and styles.
 */
function seasaltpress_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'seasaltpress-fonts', seasaltpress_google_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'seasaltpress-style', get_stylesheet_uri() );
	
	
	//jQuery 3.0 and some touch events
	
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', false, '1.8.1');
	wp_enqueue_script('jquery');
	wp_enqueue_script ( 'jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.0.0.min.js', array ( 'jquery' ), false );
	wp_enqueue_script ( 'jquery-touch', get_template_directory_uri() . '/assets/js/min/jquery.mobile.custom.min.js', array ( 'jquery', 'jquery-migrate' ), false );
	
	wp_localize_script('seasaltpress-global', 'frontEndAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce('ajax_nonce'),
	));


	wp_enqueue_script( 'seasaltpress-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$seasaltpress_l10n = array(
		'quote'          => seasaltpress_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'seasaltpress-navigation', get_theme_file_uri( '/assets/js/min/navigation-min.js' ), array(), '1.0', true );
		$seasaltpress_l10n['expand']         = __( 'Expand child menu', 'seasaltpress' );
		$seasaltpress_l10n['collapse']       = __( 'Collapse child menu', 'seasaltpress' );
		$seasaltpress_l10n['icon']           = seasaltpress_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
		$seasaltpress_l10n['sidebar_icon']   = seasaltpress_get_svg( array('icon' => 'sidebar'));
	}

	wp_enqueue_script( 'seasaltpress-global', get_theme_file_uri( '/assets/js/min/global-min.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'seasaltpress-skip-link-focus-fix', 'seasaltpressScreenReaderText', $seasaltpress_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'seasaltpress_scripts' );




/**
 * Add emmet to text areas in admin
 */
function load_custom_wp_admin_style() {
	
	    wp_enqueue_script( 'seasaltpress_emmet', get_theme_file_uri( '/assets/js/min/emmet.min.js' ), false, '1.0.0', false);
      wp_enqueue_script( 'custom_wp_admin_js', get_theme_file_uri( '/assets/js/min/custom-admin-min.js' ), array('seasaltpress_emmet'), '1.0.0', false);
               
}
//add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );




/**
 * Implement the Custom Header feature.
 */
//require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * SeaSaltPress shortcodes and extras
 */
 require get_parent_theme_file_path( '/inc/seasaltpress_extras.php' );
 
 /**
 * SeaSaltPress tinymce additions
 */
 require get_parent_theme_file_path( '/inc/tinymce_stuff/tinymce.php' );
 
 
  /**
 * SeaSaltPress Custom Fields
 */
 require get_parent_theme_file_path( '/inc/seasaltpress_custom_fields.php');