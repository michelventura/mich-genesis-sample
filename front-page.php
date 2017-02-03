<?php
 
// Enqueue styles
wp_enqueue_style( 'front-styles', get_stylesheet_directory_uri() . '/style-front.css', array(), CHILD_THEME_VERSION );
 
/**
 * Add attributes for site-inner element, since we're removing 'content'.
 *
 * @param array $attributes Existing attributes.
 * @return array Amended attributes.
 */
function be_site_inner_attr( $attributes ) {
    // Add a class of 'full' for styling this .site-inner differently
    $attributes['class'] .= ' full';
 
    // Add the attributes from .entry, since this replaces the main entry
    $attributes = wp_parse_args( $attributes, genesis_attributes_entry( array() ) );
    return $attributes;
}
add_filter( 'genesis_attr_site-inner', 'be_site_inner_attr' );
 
// Remove .site-inner's .wrap
add_theme_support( 'genesis-structural-wraps', array(
    'header',
    'nav',
    'subnav',
    // 'site-inner',
    'footer-widgets',
    'footer'
) );
 
// Display header
get_header();
 
// Content
for ( $i = 1; $i <= 3; $i++ ) {
    genesis_widget_area( "front-page-{$i}", array(
        'before' => '<div class="front-page-'.$i.' front-page-section"><div class="wrap">',
        'after'  => '</div></div>',
    ) );
}
 
// Display Footer
get_footer();