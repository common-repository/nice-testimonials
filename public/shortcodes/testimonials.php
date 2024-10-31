<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * @package   Nice_Testimonials
 * @author    NiceThemes <hello@nicethemes.com>
 * @license   GPL-2.0+
 * @link      https://nicethemes.com/product/nice-testimonials
 * @copyright 2016 NiceThemes
 * @since     1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_testimonials_shortcode' ) ) :
/**
 * Process HTML for the `testimonials` shortcode.
 *
 * @since  1.0
 *
 * @param  array  $atts
 * @return string
 */
function nice_testimonials_shortcode( $atts ) {
	// Obtain plugin settings.
	$settings = nice_testimonials_settings();

	// Normalize attributes.
	$atts = shortcode_atts( array(
		'avoidcss'           => $settings['avoidcss'],
		'limit'              => $settings['limit'],
		'columns'            => $settings['columns'],
		'orderby'            => $settings['orderby'],
		'order'              => $settings['order'],
		'category'           => '',
		'exclude_category'   => '',
		'image_size'         => $settings['image_size'],
		'include_children'   => $settings['include_children'],
		'author'             => $settings['fields']['author'],
		'avatar'             => $settings['fields']['avatar'],
		'avatar_link'        => $settings['fields']['avatar_link'],
		'url'                => $settings['fields']['url'],
		'id'                 => '',
	), $atts, 'testimonials' );

	// Set echo to false, so the output won't get printed twice.
	$atts['echo'] = false;

	$atts = apply_filters( 'nice_testimonials_shortcode_atts', $atts );

	$output = nice_testimonials( $atts );
	$output = apply_filters( 'nice_testimonials_shortcode', $output, $atts );

	return $output;
}
endif;

if ( ! shortcode_exists( 'testimonials' ) ) :
/**
 * Register `testimonials` shortcode.
 *
 * @since 1.0
 */
add_shortcode( 'testimonials', 'nice_testimonials_shortcode' );
endif;
