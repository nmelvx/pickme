<?php
/**
 * PickMe functions and definitions
 *
 * @package WordPress
 * @subpackage PickME
 * @since 1.0.0
 */


if ( ! function_exists( 'pma_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pma_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Nineteen, use a find and replace
		 * to change 'pma' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'pma', get_template_directory() . '/languages' );

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
		set_post_thumbnail_size( 1568, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-primary' => __( 'Primary', 'pma' ),
				'footer' => __( 'Footer Menu', 'pma' ),
				'social' => __( 'Social Links Menu', 'pma' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'pma_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pma_widgets_init() {

	register_sidebar(
		array(
			'name'          => __( 'Footer', 'pma' ),
			'id'            => 'sidebar-footer',
			'description'   => __( 'Add widgets here to appear in your footer.', 'pma' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}
add_action( 'widgets_init', 'pma_widgets_init' );

function pma_theme_assets() {
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'pma_theme_assets', 100 );


function pma_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	// Add [aria-haspopup] and [aria-expanded] to menu items that have children
	$item_has_children = in_array( 'menu-item-has-children', $item->classes );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
		$atts['class'] = 'dropdown-toggle';
		$atts['data-toggle'] = 'dropdown';
		$atts['role'] = 'button';
		$atts['href'] = '#';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'pma_nav_menu_link_attributes', 10, 4 );

function pma_nav_menu_submenu_css_class( $classes ) {
    $classes[] = 'dropdown-menu';
    return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'pma_nav_menu_submenu_css_class' );

/**
 * Enqueue scripts and styles.
 */
function pma_scripts() {

	wp_enqueue_style( 'pma-bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7', 'all' );
	wp_enqueue_style( 'pma-owl-style', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), '2.2.0', 'all' );
	wp_enqueue_style( 'pma-owl-theme-style', get_template_directory_uri() . '/css/owl.theme.default.min.css', array(), '2.2.0', 'all' );
	wp_enqueue_style( 'pma-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ), 'all' );	
	
	wp_enqueue_script( 'pma-jquery', get_template_directory_uri() . '/js/jquery-3.1.1.min.js', array(), '20151215', true );
	wp_enqueue_script( 'pma-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '20151215', true );
	wp_enqueue_script( 'pma-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), '20151215', true );
	wp_enqueue_script( 'pma-underscore', get_template_directory_uri() . '/js/underscore-min.js', array(), '20151215', true );
	wp_enqueue_script( 'pma-moment', get_template_directory_uri() . '/js/moment.min.js', array(), '20151215', true );
	wp_enqueue_script( 'pma-clndr', get_template_directory_uri() . '/js/clndr.js', array(), '20151215', true );
	wp_enqueue_script( 'pma-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '20151215', true );
}
add_action( 'wp_enqueue_scripts', 'pma_scripts' );


add_action('init', function() {
	pll_register_string('pma-hello', 'What\'s new for Pick Me');
	pll_register_string('pma-1', 'Why choose Pick Me Academy');
	pll_register_string('pma-2', 'Application Forms');
	pll_register_string('pma-3', 'Philosophy');
	pll_register_string('pma-4', 'Curriculum Overview');
	pll_register_string('pma-5', 'Our Staff');
	pll_register_string('pma-6', 'Fees');
	pll_register_string('pma-7', 'Parent login');
	pll_register_string('pma-8', 'Calendar');
	pll_register_string('pma-9', 'Medical');
	pll_register_string('pma-10', 'Weekly Menu');
	pll_register_string('pma-11', 'Gallery');
	pll_register_string('pma-12', 'Interested for admission ?');
	pll_register_string('pma-13', 'Already a member');
	pll_register_string('pma-14', 'Stay in touch with us');
	pll_register_string('pma-15', 'Should you have questions, require more information or like to be informed about our activities, please leave your email address below:');
});
