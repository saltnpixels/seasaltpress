<?php
/**
 * sea salt press functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sea_salt_press
 */

if ( ! function_exists( 'snp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function snp_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on sea salt press, use a find and replace
	 * to change 'snp' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'snp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );


add_theme_support( 'custom-logo' );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	set_post_thumbnail_size( 700, 430, true );
	

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'snp' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'snp_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'snp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function snp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'snp_content_width', 640 );
}
add_action( 'after_setup_theme', 'snp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function snp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'snp' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'snp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	
	//seasalt press footer widgets. set how many in customizer
	if(get_theme_mod('snp_footer_sidebars', '1') >= '1'){
		
		register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'snp' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add footer widgets here.', 'snp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	}
	
	
	if(get_theme_mod('snp_footer_sidebars', '1') >= '2'){
		
		register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'snp' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add footer widgets here.', 'snp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}


if(get_theme_mod('snp_footer_sidebars', '1') >= '3'){
		
		register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'snp' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add footer widgets here.', 'snp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
	
	
}
add_action( 'widgets_init', 'snp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function snp_scripts() {
	wp_enqueue_style( 'snp-style', get_stylesheet_uri() );

	wp_enqueue_script( 'snp-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20151215', true );
	
  wp_enqueue_style('source-sans-pro', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,600i');

//added localized script for my menu
	wp_localize_script( 'snp-navigation', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'quickpress' ),
		'collapse' => __( 'collapse child menu', 'quickpress' ),
	) );
	
	wp_enqueue_script( 'snp-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	
//scrollmagic
	wp_enqueue_script('quickpress-gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js');
  wp_enqueue_script('quickpress-scrollmagic', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js');
	wp_enqueue_script('quickpress-scrollmagic-debug', 'https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js');
	wp_enqueue_script('quickpress-gsap-scroll', get_template_directory_uri() . '/js/animation.gsap.js');
	
	
	//my fontawesome
	wp_enqueue_script('fontAwesome', 'https://use.fontawesome.com/4a2cebc3ec.js', true);
	
	//prism.js and css
	wp_enqueue_script('prismJs', get_template_directory_uri() . '/js/prism.js', true);
	
	
	
	//modernizr
	wp_enqueue_script('quickpress-modernizr', get_template_directory_uri() . '/js/modernizr.custom.js');
	
	wp_enqueue_script( 'snp-animations', get_template_directory_uri() . '/js/animations.js', array('jquery'), '2011215', true );
	
	wp_localize_script('snp-animations', 'frontEndAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce('ajax_nonce')
	));

	

  //fancybox
  wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.pack.js');
  wp_enqueue_style('fancybox-ui', get_template_directory_uri() . '/js/fancybox/jquery.fancybox.css');
  	
}
add_action( 'wp_enqueue_scripts', 'snp_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/*--------------------------------------------------------------
# get sea salt press additions
--------------------------------------------------------------*/


require get_template_directory() . '/inc/snp_extras.php';

require get_template_directory() . '/inc/tinymce_stuff/tinymce_buttons.php';

