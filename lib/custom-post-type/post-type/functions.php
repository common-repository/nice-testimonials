<?php
/**
 * NiceThemes Post Type API
 *
 * This file includes actions to handle plugin activation.
 *
 * @package Nice_Testimonials_Post_Type
 * @license GPL-2.0+
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nice_testimonials_post_type_register' ) ) :
/**
 * Register a new custom post type.
 *
 * @uses  Nice_Testimonials_Helper::register_custom_post_type()
 *
 * @since 1.1
 *
 * Accepted $args:
 *
	array(
		'post_type'  => array(
				'name'     => 'post-type-slug',
				'labels'   => {all possible CPT labels},
				'supports' => {all possible supported elements},
				'args'     => {all possible CPT arguments}
			),
			'taxonomies' => array(
			array(
				'name'   => 'post-type-taxonomy-slug',
				'labels' => {all possible CPT taxonomy labels},
				'args'   => {all possible CPT taxonomy arguments}
			)
		)
	)
 *
 *
 * @param array  $args       Arguments to construct the new custom post type.
 * @param string $textdomain Text domain for the new post type.
 */
function nice_testimonials_post_type_register( $args = array(), $textdomain ) {
	$post_type = nice_testimonials_post_type_create( array(
			'textdomain' => $textdomain,
			'args'       => $args['post_type'],
			'taxonomies' => $args['taxonomies'],
		)
	);

	/**
	 * Add styling to the dashboard for the post type and adds custom posts to
	 * the "At a Glance" metabox.
	 */
	if ( is_admin() ) {
		nice_testimonials_post_type_admin_create( array(
				'post_type'  => $post_type,
				'textdomain' => $textdomain,
			)
		);
	}
}
endif;

/**
 * Create a new post type.
 *
 * @uses   nice_testimonials_create()
 *
 * @since  1.1
 *
 * @param  array $data Information for new instance.
 *
 * @return Nice_Testimonials_Post_TypeService
 */
function nice_testimonials_post_type_create( array $data = array() ) {
	return nice_testimonials_create( 'Nice_Testimonials_Post_Type', $data );
}

/**
 * Obtain service for this domain.
 *
 * @uses   nice_testimonials_service()
 *
 * @since  1.1
 *
 * @return Nice_Testimonials_Post_TypeService
 */
function nice_testimonials_post_type_service() {
	return nice_testimonials_service( 'Nice_Testimonials_Post_Type' );
}
