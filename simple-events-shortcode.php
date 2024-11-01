<?php
/*
Plugin Name: Simple Events Shortcode 
Plugin URI: http://www.webwobble.com/1/wordpress-plugin-simple-events-shortcode/
Description: This plugin adds an 'Events' link to your admin menu. Add a new event. Then, add a new page called 'Events' or whatever you want to call it.  Then, put the shortcode [simple_events_shortcode] on that page, and your events will be displayed.
Author: Chris Antonick
Version: 1.0.2
Author URI: http://www.webwobble.com/
*/

/**
 * Adds the custom post type
 */
function simple_events_shortcode_post_type() {
	register_post_type( 
		'sesc1_events',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' )
			),
			'public' => true,
			'has_archive' => false,
			'menu_position'=>5
			//,'rewrite' => array('slug' => 'events')
		)
	);
}

/**
 * simple_events_shortcode  shortcode function
 *
 * @use [simple_events_shortcode]
 */
function simple_events_shortcode_func( $atts ) {
	extract( shortcode_atts( array(
		'content' => 'all_content',
		'link' => 'no_link'
	), $atts ) );

	//TODO remove these hard-coded attribute-overrides in next version release
	$content = 'all_content';
	$link = 'no_link';

	return display_simple_events_shortcode($link, $content);
}

/**
 * Display the custom-type posts
 *
 * The params will do something in future versions
 *
 * @param String $link 
 * @param String $content
 * @return String $html_str 
 */
function display_simple_events_shortcode($link='',$content=''){
	$html_str = '';	

	$args = array( 'post_type' => 'sesc1_events', 'posts_per_page' => 100 );
	$loopy = new WP_Query( $args );

	while ( $loopy->have_posts() ) { 
		$loopy->the_post();
		$html_str .= 
			'<div class="entry-content">'
			. '<h3>'. get_the_title() . '</h3>'
			. '<div>'. wpautop(get_the_content()). '</div>'
			.'</div>';

	}

	return $html_str; 
}

add_shortcode( 'simple_events_shortcode', 'simple_events_shortcode_func' );
add_action( 'init', 'simple_events_shortcode_post_type' );
