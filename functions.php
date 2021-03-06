<?php
/**
 * Pollution Tracker functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pollution_Tracker
 */

if ( ! function_exists( 'tracker_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tracker_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Pollution Tracker, use a find and replace
		 * to change 'tracker' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tracker', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'tracker' ),
			'footer-top' => esc_html__( 'Footer top', 'tracker' ),
			'footer-bottom' => esc_html__( 'Footer bottom', 'tracker' ),
            'contaminant-left-nav' => esc_html__( 'Contaminant left nav', 'tracker' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'tracker_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'tracker_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tracker_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tracker_content_width', 640 );
}
add_action( 'after_setup_theme', 'tracker_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tracker_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'tracker' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'tracker' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tracker_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tracker_scripts() {
	wp_enqueue_style( 'tracker-style', get_stylesheet_uri(), false, filemtime(get_stylesheet_directory() . '/style.css') );
	wp_enqueue_style( 'hello-bar', get_template_directory_uri() . '/hello-bar.css',false, filemtime(get_stylesheet_directory() . '/hello-bar.css') );
	wp_enqueue_style( 'social-icon-font', 'https://d1azc1qln24ryf.cloudfront.net/114779/Socicon/style-cf.css?u8vidh',false );
	wp_enqueue_style( 'tooltipster', get_template_directory_uri() . '/js/tooltipster.bundle.min.css',false );
    wp_enqueue_style( 'tooltipster-theme', get_template_directory_uri() . '/js/tooltipster-sideTip-shadow.min.css',false );

    //wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro',false );

    //wp_deregister_style('et-builder-modules-style');

	wp_enqueue_script( 'tracker-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), filemtime(get_stylesheet_directory() . '/js/navigation.js'), false );
    wp_localize_script( 'tracker-navigation', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));


	wp_enqueue_script( 'tracker-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    wp_enqueue_script( 'tooltipster', get_template_directory_uri() . '/js/tooltipster.bundle.min.js', array(), '20151215', true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tracker_scripts', 99 ); // To load our stylesheet last


add_filter( 'password_protected_is_active', 'check_password_protected');
// Disable Password Protected for temporary map page (for client preview)
function check_password_protected($arg1){
    global $post;
    if ($post) {
        $slug = $post->post_name;
        if ($slug && $slug == 'map') return false;
    }
    return true;
}


/**
 * Implement the Custom Header feature.
 */
require get_theme_file_path() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_theme_file_path() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_theme_file_path() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_theme_file_path() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_theme_file_path() . '/inc/jetpack.php';
}

