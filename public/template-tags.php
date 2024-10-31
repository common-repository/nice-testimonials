<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * This file contains functions that print HTML.
 *
 * @package Nice_Testimonials
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_testimonials' ) ) :
/**
 * Display testimonials with given arguments.
 *
 * @since  1.0
 *
 * @param  array  $args Arguments to construct output.
 * @return string
 */
function nice_testimonials( $args = array() ) {
	// Allow bypass.
	if ( $output = apply_filters( 'nice_testimonials_custom', '', $args ) ) {
		return $output;
	}

	// Obtain plugin settings.
	$settings = nice_testimonials_settings();

	// Normalize attributes.
	$defaults = apply_filters( 'nice_testimonials_default_args', array(
			'avoidcss'         => $settings['avoidcss'],
			'limit'            => $settings['limit'],
			'columns'          => $settings['columns'],
			'orderby'          => $settings['orderby'],
			'order'            => $settings['order'],
			'category'         => '',
			'exclude_category' => '',
			'image_size'       => $settings['image_size'],
			'include_children' => $settings['include_children'],
			'author'           => $settings['fields']['author'],
			'avatar'           => $settings['fields']['avatar'],
			'avatar_link'      => $settings['fields']['avatar_link'],
			'url'              => $settings['fields']['url'],
			'id'               => '',
			'echo'             => true,
		)
	);
	$args = wp_parse_args( $args, $defaults );

	// Adjust boolean properties.
	$args['avoidcss']         = ( 'true' == $args['avoidcss'] ) ? $args['avoidcss'] : ( '1' == $args['avoidcss'] ); // WPCS: loose comparison ok.
	$args['include_children'] = ( 'false' == $args['include_children'] ) ? false : ( '1' == $args['include_children'] ); // WPCS: loose comparison ok.
	$args['author']           = ( 'false' == $args['author'] ) ? false : ( '1' == $args['author'] ); // WPCS: loose comparison ok.
	$args['avatar']           = ( 'false' == $args['avatar'] ) ? false : ( '1' == $args['avatar'] ); // WPCS: loose comparison ok.
	$args['avatar_link']      = ( 'false' == $args['avatar_link'] ) ? false : ( '1' == $args['avatar_link'] ); // WPCS: loose comparison ok.
	$args['url']              = ( 'false' == $args['url'] ) ? false : ( '1' == $args['url'] ); // WPCS: loose comparison ok.

	$args = apply_filters( 'nice_testimonials_args', $args );

	$output = nice_testimonials_output( $args );

	return $output;
}
endif;
