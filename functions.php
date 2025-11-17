<?php
/**
 * LandingPadTheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package LandingPadTheme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function landingpadtheme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on LandingPadTheme, use a find and replace
		* to change 'landingpadtheme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'landingpadtheme', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'header_menu' => esc_html__( 'Header menu', 'landingpadtheme' ),
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
	add_theme_support(
		'custom-background',
		apply_filters(
			'landingpadtheme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'landingpadtheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function landingpadtheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'landingpadtheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'landingpadtheme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function landingpadtheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'landingpadtheme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'landingpadtheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'landingpadtheme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function landingpadtheme_scripts() {
	wp_enqueue_style( 'landingpadtheme-style', get_stylesheet_uri(), array(), _S_VERSION );

	wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/vendor/slick/slick.css', array(),  '1.8.1' );

    wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/vendor/slick/slick.min.js', array('jquery'), '1.8.1', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'landingpadtheme_scripts' );


// -- VITE SETUP

function vite_assets() {

	$vite_dev_server = 'http://localhost:5173';

	$is_dev = defined('VITE_DEV_MODE') && VITE_DEV_MODE === true;

	if ( $is_dev ) {
		// dev mode
		wp_enqueue_script( 'vite-client', $vite_dev_server . '/@vite/client', [], null, true );

		wp_enqueue_script( 'main-js', $vite_dev_server . '/src/js/main.js', array('jquery', 'slick-js'), '1.0', true );
	} else {
		// prod mode
		$dist_path = get_template_directory_uri() . '/dist/';
		$dist_dir = get_template_directory() . '/dist/';

		$manifest_file = $dist_dir . '.vite/manifest.json';

		if ( file_exists( $manifest_file ) ) {
			$manifest = json_decode( file_get_contents( $manifest_file ), true );

			if ( isset( $manifest['src/js/main.js'] ) ) {
				wp_enqueue_script( 'main-js', $dist_path . $manifest['src/js/main.js']['file'], array('jquery'), null, true );
			}
			if ( isset( $manifest['src/scss/main.scss'] ) ) {
                wp_enqueue_style( 'main-css', $dist_path . $manifest['src/scss/main.scss']['file'], [], null );
            }
		}
	}
}
add_action( 'wp_enqueue_scripts', 'vite_assets' );

// add type module for vite scripts
function add_module_type_attribute( $tag, $handle, $src ) {
    if ( $handle === 'vite-client' || $handle === 'main-js' ) {
        
        $is_dev = defined('VITE_DEV_MODE') && VITE_DEV_MODE === true;
        
        if ( $is_dev ) {
            // dev mode
             $tag = '<script type="module" src="' . esc_url( $src ) . '" id="' . $handle . '-js"></script>';
        } else {
            // prod mode
            if ($handle === 'main-js') {
                 $tag = '<script type="module" src="' . esc_url( $src ) . '" id="' . $handle . '-js"></script>';
            }
        }
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'add_module_type_attribute', 10, 3 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


// CUSTOM

// change custom logo, remove <img> and return <svg></svg>
function landingpad_get_inline_logo() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    
    if ( ! $custom_logo_id ) {
        return;
    }

    $logo_file = get_attached_file( $custom_logo_id );
    
    $mime_type = get_post_mime_type( $custom_logo_id );
    
    if ( file_exists( $logo_file ) && 'image/svg+xml' === $mime_type ) {
        return file_get_contents( $logo_file );
    }
    
    return wp_get_attachment_image( $custom_logo_id, 'full' );
}

// CPT Testimonials
function landingpad_register_testimonials_cpt() {
	$labels = array(
		'name' => 'Testimonials',
		'singular_name' => 'Testimonial',
		'menu_name' => 'Testimonials',
		'add_new' => 'Add new',
		'add_new_item' => 'Add new testimonial',
		'edit_item' => 'Edit testimonial',

	);
	$args = array(
		'labels' => $labels,
		'public' => false,
		'has_archive' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_icon' => 'dashicons-format-quote',
		'supports' => array( 'title', 'editor' ),
		'menu_position' => 26,
	);
	register_post_type( 'testimonials', $args );
}
add_action( 'init', 'landingpad_register_testimonials_cpt' );


// change placeholder in title on Testimonial CPT and Team CPT
function landingpad_change_cpt_title_placeholders( $title ) {
    $screen = get_current_screen();
    if ( ! $screen ) {
        return $title;
    }

    if ( 'testimonials' === $screen->post_type ) {
        return 'Add author name';
    }

    if ( 'team' === $screen->post_type ) {
        return 'Add member name';
    }

    return $title;
}
add_filter( 'enter_title_here', 'landingpad_change_cpt_title_placeholders' );

// CPT Team
function landingpad_register_team_cpt() {
	$labels = array(
		'name' => 'Team',
		'singular_name' => 'Team member',
		'menu_name' => 'Team',
		'add_new' => 'Add new member',
		'add_new_item' => 'Add new member',

	);
	$args = array(
		'labels' => $labels,
		'public' => false,
		'has_archive' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_icon' => 'dashicons-groups',
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'menu_position' => 27,
	);
	register_post_type( 'team', $args );
}
add_action( 'init', 'landingpad_register_team_cpt' );


// Added Options Page
if ( function_exists('acf_add_options_page') ) {
    
    acf_add_options_page(array(
        'page_title'    => 'Site General Settings',
        'menu_title'    => 'Site Settings',
        'menu_slug'     => 'site-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'icon_url'      => 'dashicons-admin-generic',
        'position'      => 28
    ));
}