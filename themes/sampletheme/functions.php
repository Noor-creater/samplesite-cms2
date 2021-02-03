<?php
/**
 * Sample Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Sample_Theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.change after release
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'sampletheme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function sampletheme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Sample Theme, use a find and replace
		 * to change 'sampletheme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'sampletheme', get_template_directory() . '/languages' );

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
		//Here i changed the name of menu and added needed menu here 
		register_nav_menus(
			array(
				'menu-primary' => esc_html__( 'Primary', 'sampletheme' ),/*change the name, esc-html to enable word primary to be translated to other languages*/
				'menu-secondary' => esc_html__( 'Secondary', 'sampletheme' ),
				)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		//better to disable this feature for users
		/*add_theme_support(if we comment this will remove changing bg color ability from dashboard
			'custom-background',
			apply_filters(
				'sampletheme_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);*/

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(/*we leave this to user to do custom logo*/
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);



		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
	}
endif;
//end setup 
add_action( 'after_setup_theme', 'sampletheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sampletheme_content_width() {/* this change the width of content */
	$GLOBALS['content_width'] = apply_filters( 'sampletheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'sampletheme_content_width', 0 );

/**
 * Register widget area./side bar area/
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sampletheme_widgets_init() {/* if i go to widget in dashboard , i can custom a sidebar*/
	register_sidebar(/* i can register more than one side bar*/
		array(
			'name'          => esc_html__( 'Sidebar', 'sampletheme' ),
			'id'            => 'sidebar',/*remove number*/
			'description'   => esc_html__( 'Add widgets here.', 'sampletheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'sampletheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sampletheme_scripts() {
	//load only main style sheet ( handle, path, array of dependencies , version(to be updated automatically))
	wp_enqueue_style( 'sampletheme-style', get_stylesheet_uri(), array(), _S_VERSION );

	// wp_style_add_data( 'sampletheme-style', 'rtl', 'replace' ); no need to have right to left

	//delete line related (enque script to navigation) no need to load it  

	//this to leave comments 
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sampletheme_scripts' );

/**
 * Implement the Custom Header feature.
 *///comment this we dont need it 
// require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
// if ( defined( 'JETPACK__VERSION' ) ) {
// 	require get_template_directory() . '/inc/jetpack.php';
// }

/**
 * Enqueing block editor assets
 */

 function sampletheme_enqueue_block_editor_assets() {
	wp_enqueue_script(
		'editor-script',
		get_template_directory_uri() . '/assets/js/editor.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post')
	);
 }

 add_action( 'enqueue_block_editor_assets','sampletheme_enqueue_block_editor_assets');

//  register_block_style(
//     'core/quote',
//     array(
//         'name'         => 'blue-quote',
//         'label'        => __( 'Blue Quote' ),
//         'inline_style' => '.wp-block-quote.is-style-blue-quote { color: blue; }',
//     )
// );

/**
 * Enqueuing block assets
 */

 function sampletheme_enqueue_block_assets() {
	wp_enqueue_style(
		'editor-style',
		get_template_directory_uri() . '/assets/css/editor.cs'
		
	);
}

 add_action( 'enqueue_block_asets','sampletheme_enqueue_block_assets');