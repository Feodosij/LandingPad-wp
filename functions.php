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

	wp_localize_script( 'main-js', 'landingpad_vars', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'load_more_nonce' )
	));
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

// dynamic change colors on different pages
function landingpad_output_dynamic_colors() {
    $defaults = [
        'accent_main'     => '#2967F0',
        'accent_bg'       => '#DBEBFF',
        'accent_font'     => '#0F38B4',
        'accent_bg_light' => '#F9FBFF',
    ];

    $main     = !empty($GLOBALS['accent_main'])     ? $GLOBALS['accent_main']     : $defaults['accent_main'];
    $bg       = !empty($GLOBALS['accent_bg'])       ? $GLOBALS['accent_bg']       : $defaults['accent_bg'];
    $font     = !empty($GLOBALS['accent_font'])     ? $GLOBALS['accent_font']     : $defaults['accent_font'];
    $bg_light = !empty($GLOBALS['accent_bg_light']) ? $GLOBALS['accent_bg_light'] : $defaults['accent_bg_light'];

    ?>
    <style id="landingpad-dynamic-vars">
        :root {
            --accent_main:     <?php echo esc_attr($main); ?>;
            --accent_bg:         <?php echo esc_attr($bg); ?>;
            --accent_font:     <?php echo esc_attr($font); ?>;
            --accent_bg_light: <?php echo esc_attr($bg_light); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'landingpad_output_dynamic_colors', 100);


// ajax load more apartments
function landingpad_load_more_apartments() {
    check_ajax_referer('load_more_nonce', 'nonce');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $term_slug = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
    $posts_per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 3;

    $args = array(
        'post_type'      => 'apartment',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'tax_query'      => array(
            array(
                'taxonomy' => 'apartments_category',
                'field'    => 'slug',
                'terms'    => $term_slug,
            ),
        ),
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/content', 'apartment-card' );
        }
    } else {
        echo ''; 
    }

    wp_reset_postdata();
    wp_die();
}
add_action( 'wp_ajax_load_more_apartments', 'landingpad_load_more_apartments' );
add_action( 'wp_ajax_nopriv_load_more_apartments', 'landingpad_load_more_apartments' );

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
        'position'      => 29
    ));
}

// remove defaults tag cf7
add_filter( 'wpcf7_autop_or_not', '__return_false' );

// CPT Services
function landingpad_register_services_cpt() {
	$labels = array(
		'name' => 'Services',
		'singular_name' => 'Service',
		'menu_name' => 'Services',
		'add_new' => 'Add new service',
		'add_new_item' => 'Add new service',

	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_icon' => 'dashicons-buddicons-activity',
		'supports' => array( 'title', 'thumbnail', 'page-attributes' ),
		'menu_position' => 28,

		'rewrite' => array( 'slug' => 'services' ),
	);
	register_post_type( 'services', $args );
}
add_action( 'init', 'landingpad_register_services_cpt' );

// added lazy-loading to thumbnail
function add_lazy_load_to_post_thumbnail($html) {
    if ( strpos( $html, 'loading=' ) === false ) {
        $html = str_replace('<img', '<img loading="lazy"', $html);
    }
    return $html;
}
add_filter('post_thumbnail_html', 'add_lazy_load_to_post_thumbnail', 10, 1);

// change menu style for some page
add_filter( 'body_class', function( $classes ) {

    if ( is_singular( 'services' ) || is_singular( 'apartment' )  ) {
        $classes[] = 'header_light_style';
    }

    return $classes;
});

// remove default sending mail cf7 (for test sending)
add_filter( 'wpcf7_skip_mail', '__return_true' );

// register rewrite tag
function lp_add_rewrite_tag() {
    add_rewrite_tag( '%apartments_category%', '([^/]+)' );
}
add_action( 'init', 'lp_add_rewrite_tag', 5 );


// register taxonomy cpt apartments
function landingpad_register_apartment_taxonomy() {
    $labels = array(
        'name' => 'Apartment Categories',
        'singular_name' => 'Category',
    );
    
    register_taxonomy('apartments_category', 'apartment', array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
		'show_ui' => true,
        'show_admin_column' => true,
        'rewrite' => false,
    ));
    
    register_taxonomy('apartment_tag', 'apartment', array(
        'labels' => array('name' => 'Apartment Tags'),
        'hierarchical' => false,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'apartment-tag'),
    ));
}
add_action('init', 'landingpad_register_apartment_taxonomy', 6 );

// CPT Apartments
function landingpad_register_apartments_cpt() {
	$labels = array(
		'name' => 'Apartments',
		'singular_name' => 'Apartment',
		'menu_name' => 'Apartments',
		'add_new' => 'Add new partment',
		'add_new_item' => 'Add new apartment',

	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => false,
		'publicly_queryable' => true,
		'menu_icon' => 'dashicons-building',
		'supports' => array( 'title', 'thumbnail', 'editor'),
		'menu_position' => 30,
		'rewrite' => array( 
            'slug' => 'apartments/%apartments_category%', 
            'with_front' => false 
        ),
	);
	register_post_type( 'apartment', $args );
}
add_action( 'init', 'landingpad_register_apartments_cpt', 10 );

// change apartment permalink
function landingpad_apartment_link_filter( $post_link, $post ) {
    if ( 'apartment' !== $post->post_type ) {
        return $post_link;
    }

    $terms = get_the_terms( $post->ID, 'apartments_category' );
    if ( $terms && ! is_wp_error( $terms ) ) {
        $term_slug = $terms[0]->slug;
    } else {
        $term_slug = 'rent';
    }

    return home_url( user_trailingslashit( $term_slug . '/' . $post->post_name ) );
}
add_filter( 'post_type_link', 'landingpad_apartment_link_filter', 10, 2 );


function lp_add_apartment_rewrite_rules() {
    $terms_regex = 'rent|buy|build';

    add_rewrite_rule( '^(' . $terms_regex . ')/([^/]+)/?$', 'index.php?post_type=apartment&name=$matches[2]', 'top' );
}
add_action( 'init', 'lp_add_apartment_rewrite_rules', 11 );


// connect google maps api
function my_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyBVs_ngHQFa0QLSpzS6ZspdKbrZLrsuSlQ';
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

function theme_enqueue_google_maps() {
    if ( is_singular('apartment') ) {

		$api_url = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBVs_ngHQFa0QLSpzS6ZspdKbrZLrsuSlQ';

        wp_enqueue_script(
            'google-maps',
            $api_url,
            [],
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_google_maps');