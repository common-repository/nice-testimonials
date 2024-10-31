<?php
/**
 * NiceThemes Plugin API
 *
 * This file contains general helper functions that allow interactions with
 * this module in an easier way.
 *
 * @package Nice_Testimonials_Plugin_API
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'nice_testimonials_integration_create' ) ) :
/**
 * Create and obtain a new instance of Nice_Testimonials_Integration.
 *
 * @since  1.0
 *
 * @uses   nice_testimonials_create()
 *
 * @param  array $data Data to create the new instance.
 *
 * @return Nice_Testimonials_Integration
 */
function nice_testimonials_integration_create( array $data ) {
	return nice_testimonials_create( 'Nice_Testimonials_Integration', $data );
}
endif;
