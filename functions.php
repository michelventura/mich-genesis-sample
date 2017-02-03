<?php
/**
 * Mich Genesis Sample Theme.
 *
 * This file adds functions to Mich Genesis Sample Theme.
 *
 * @package Mich Genesis Sample
 * @author  michelventura
 * @license GPL-2.0+
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
function genesis_sample_localization_setup(){
	load_child_theme_textdomain( 'mich-genesis-sample', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Mich Genesis Sample' );
define( 'CHILD_THEME_URL', 'https://github.com/michelventura/mich-genesis-sample.git' );
define( 'CHILD_THEME_VERSION', '2.3.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'mich-genesis-sample-fonts', '//fonts.googleapis.com/css?family=Lato:400,700,700italic', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'flexboxgrid', CHILD_URL . '/css/flexboxgrid.min.css' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'mich-genesis-sample' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'mich-genesis-sample' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );
add_image_size( 'landing-page', 1600, 384, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'mich-genesis-sample' ), 'secondary' => __( 'Footer Menu', 'mich-genesis-sample' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
function genesis_sample_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

// Register front-page widget areas
for ( $i = 1; $i <= 3; $i++ ) {
    genesis_register_widget_area(
        array(
            'id'          => "front-page-{$i}",
            'name'        => __( "Front Page {$i}", 'mich-genesis-sample' ),
            'description' => __( "This is the front page {$i} section.", 'mich-genesis-sample' ),
        )
    );
}

/**
 * Remove Genesis Page Templates
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/remove-genesis-page-templates
 *
 * @param array $page_templates
 * @return array
 */
function be_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'be_remove_genesis_page_templates' );

// Add class for screen readers to site description
add_filter( 'genesis_attr_site-description', 'genesis_attributes_screen_reader_class' );

// Add post navigation
add_action( 'genesis_after_loop', 'genesis_prev_next_post_nav' );

// Display author box on single posts
// add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

// Remove Post Info from entries of all post types excerpt 'post'
add_action( 'init', 'mich_conditional_post_info', 11 );
function mich_conditional_post_info() {

	$public_post_types = get_post_types( array( 'public' => true, '_builtin' => false ) );

	foreach ( $public_post_types as $post_type ) {
		remove_post_type_support( $post_type, 'genesis-entry-meta-before-content' );
	}
}

/**
 * Remove Metaboxes
 * This removes unused or unneeded metaboxes from Genesis > Theme Settings.
 * See /genesis/lib/admin/theme-settings for all metaboxes.
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/remove-metaboxes-from-genesis-theme-settings/
 */
function be_remove_metaboxes( $_genesis_theme_settings_pagehook ) {
	remove_meta_box( 'genesis-theme-settings-blogpage', $_genesis_theme_settings_pagehook, 'main' );
}
add_action( 'genesis_theme_settings_metaboxes', 'be_remove_metaboxes' );

//* Remove the edit link
add_filter ( 'genesis_edit_post_link' , '__return_false' );

/* Change the footer text */
add_filter('genesis_footer_creds_text', 'custom_footer_creds_filter');
function custom_footer_creds_filter( $creds ) {
	$creds = 'Copyright [footer_copyright] <a href="'.get_bloginfo( 'url' ).'">'.get_bloginfo( 'name' ).'</a>.';
	return $creds;
}

// Enable shortcodes in text widgets
add_filter( 'widget_text','do_shortcode' );

//* Customize the entry meta in the entry footer (requires HTML5 theme support)
add_filter( 'genesis_post_meta', 'mich_post_meta_filter' );
function mich_post_meta_filter($post_meta) {
	$post_meta = '[post_categories before="En Categoria: "]';
	return $post_meta;
}

//* Unregister Genesis widgets
add_action( 'widgets_init', 'unregister_genesis_widgets', 20 );
function unregister_genesis_widgets() {
	unregister_widget( 'Genesis_eNews_Updates' );
	unregister_widget( 'Genesis_Featured_Page' );
	unregister_widget( 'Genesis_Featured_Post' );
	unregister_widget( 'Genesis_Latest_Tweets_Widget' );
	unregister_widget( 'Genesis_Menu_Pages_Widget' );
	unregister_widget( 'Genesis_User_Profile_Widget' );
	//unregister_widget( 'Genesis_Widget_Menu_Categories' );
}

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister Genesis layout settings
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Add custom body class for pages
add_filter( 'body_class', 'custom_body_class_for_pages' );
/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function custom_body_class_for_pages( $classes ) {

	if ( is_singular( 'page' ) ) {
		global $post;
		$classes[] = 'page-' . $post->post_name;
	}

	return $classes;

}

//* Customize the next page link
add_filter ( 'genesis_next_link_text' , 'mich_next_page_link' );
function mich_next_page_link ( $text ) {
    return 'Siguiente página &#x000BB;';
}

//* Customize the previous page link
add_filter ( 'genesis_prev_link_text' , 'mich_previous_page_link' );
function mich_previous_page_link ( $text ) {
    return '&#x000AB; Página anterior';
}

// Change search form textdomain
add_filter( 'genesis_search_text', 'mich_custom_search_button_text' );
function mich_custom_search_button_text( $text ) {
return ( 'Buscar ...');
}

// Prevent CSS and JavaScript from loading on all pages
if ( is_archive() || is_front_page() ) {
    remove_action( 'wp_enqueue_scripts', 'FLBuilder::layout_styles_scripts' );
}
