<?php
/**
 * Template Name: Landing
 */

// Add landing page body class to the head.
add_filter( 'body_class', 'mich_genesis_sample_add_body_class' );
function mich_genesis_sample_add_body_class( $classes ) {

	$classes[] = 'landing-page';

	return $classes;

}

// Remove Skip Links.
remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

// Dequeue Skip Links Script.
add_action( 'wp_enqueue_scripts', 'mich_genesis_sample_dequeue_skip_links' );
function mich_genesis_sample_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Reposition entry header
add_action( 'genesis_header', function() {
    // if featured image is not present, abort.
    if ( !has_post_thumbnail() ) {
        return;
    }
 
    // Remove entry header from its default location
    remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
    remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
 
    // Add entry header below header
    add_action( 'genesis_after_header', 'genesis_entry_header_markup_open' );
    add_action( 'genesis_after_header', 'genesis_do_post_title' );
    add_action( 'genesis_after_header', 'genesis_entry_header_markup_close' );
});
 
// Set featured image as URL of .entry-header
add_action( 'genesis_attr_entry-header', function( $attributes ) {
    // if featured image is not present, abort.
    if ( !has_post_thumbnail() ) {
        return;
    }
 
    $attributes['style'] = 'background-image: url('.wp_get_attachment_image_src( get_post_thumbnail_id(), 'landing-page' )[0].')';
 
    return $attributes;
});

// Run the Genesis loop.
genesis();
