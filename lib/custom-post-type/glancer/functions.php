<?php
/**
 * NiceThemes Plugin API
 *
 * This file contains general helper functions that allow interactions with
 * this module in an easier way.
 *
 * @package Nice_Testimonials_Plugin_API
 * @license GPL-2.0+
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create and return an instance of Nice_Testimonials_glancer.
 *
 * @uses   nice_testimonials_create()
 *
 * @since  1.1
 *
 * @param  array           $data Information for new instance.
 *
 * @return Nice_Testimonials_Glancer
 */
function nice_testimonials_glancer_create( array $data ) {
	/**
	 * Create a glancer instance and initialize its functionality.
	 */
	return nice_testimonials_create( 'Nice_Testimonials_Glancer', $data );
}

/**
 * Obtain an instance of this domain's service.
 *
 * @uses   nice_testimonials_service()
 *
 * @since  1.1
 *
 * @return Nice_Testimonials_GlancerService
 */
function nice_testimonials_glancer_service() {
	return nice_testimonials_service( 'Nice_Testimonials_Glancer' );
}

/**
 * Register one or more post type items to be shown on the dashboard widget.
 *
 * @uses  nice_testimonials_glancer_service()
 * @uses  Nice_Testimonials_GlancerService::add_item()
 *
 * @since 1.1
 *
 * @param Nice_Testimonials_Glancer $glancer Instance to be updated.
 * @param array|string  $post_types Post type name, or array of post type names.
 * @param array|string  $statuses Post status or array of different post type statuses
 * @param string $glyph Dashicons glyph for current post type.
 */
function nice_testimonials_glancer_add_item( Nice_Testimonials_Glancer $glancer, $post_types, $statuses = 'publish', $glyph = '' ) {
	$glancer_service = nice_testimonials_glancer_service();
	$glancer_service->add_item( $glancer, $post_types, $statuses, $glyph );
}
