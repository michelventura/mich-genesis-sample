<?php
/**
 * Template Name: Full Width
 */

// Full Page Genesis Beaver
add_action( 'wp_head', 'custom_genesis_page_fullwidth_styles' );
function custom_genesis_page_fullwidth_styles() {
	echo '<style type="text/css">.page-fullwidth,.page-fullwidth .site-container,.page-fullwidth .site-container .site-inner{max-width:100%;width:100%;background:none;border:0;float:none;margin:0 auto;padding:0;box-shadow:none;border-radius:0;-webkit-border-radius:0;-webkit-box-shadow:none}.page-fullwidth .center-block{margin:0 auto}.page-fullwidth .center-text{text-align:center}.page-fullwidth .clearfix:before,.clearfix:after{content:"\0020";display:table}.page-fullwidth .clearfix:after{clear:both}.page-fullwidth .clearfix{*zoom:1}@media screen and (max-width: 500px){.page-fullwidth .fl-row-bg-video video{left:0!important}.page-fullwidth .fl-row-bg-video{min-width:360px}}</style>';
    }

add_filter( 'body_class', 'custom_genesis_page_fullwidth_body_class' );
/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function custom_genesis_page_fullwidth_body_class( $classes ) {
	$classes[] = 'page-fullwidth';
	return $classes;
}

add_filter( 'genesis_attr_site-inner', 'custom_genesis_page_fullwidth_attributes_site_inner' );
/**
 * Add attributes for site-inner element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function custom_genesis_page_fullwidth_attributes_site_inner( $attributes ) {
	$attributes['role']     = 'main';
	$attributes['itemprop'] = 'mainContentOfPage';

	return $attributes;
}

// Remove div.site-inner's div.wrap
add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );

// Display Header
get_header();

// Display Content
the_post(); 
the_content();

// Display Footer
get_footer();