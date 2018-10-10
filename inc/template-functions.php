<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package AJAW
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ajaw_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'ajaw_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ajaw_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ajaw_pingback_header' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ajaw_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ajaw' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ajaw' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s" itemprop="mainEntity">',
		'after_widget'  => '</section>',
		'before_title'  => '<div class="widget-title-container"><h4 class="widget-title" itemprop="name">',
		'after_title'   => '</h4></div>',

	) );
}
add_action( 'widgets_init', 'ajaw_widgets_init' );
