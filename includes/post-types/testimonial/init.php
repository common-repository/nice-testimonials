<?php
/**
 * Register the testimonials post type.
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

if ( ! function_exists( 'nice_testimonials_add_post_type' ) ) :
add_filter( 'nice_testimonials_post_types', 'nice_testimonials_add_post_type' );
/**
 * Register the testimonials post type using our CPT creator library.
 *
 * @since  1.0
 *
 * @param  array $post_types List of current post types.
 *
 * @return array
 */
function nice_testimonials_add_post_type( array $post_types = array() ) {
	// Prepare arguments.
	$post_type = array(
		'args'       => apply_filters( 'nice_testimonials_post_type', array() ),
		'taxonomies' => array( apply_filters( 'nice_testimonials_category', array() ) ),
		'textdomain' => 'nice-testimonials',
	);

	$post_types[] = apply_filters( 'nice_testimonials_register_testimonials_args', $post_type );

	return $post_types;
}
endif;
