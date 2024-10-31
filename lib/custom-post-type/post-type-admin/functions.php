<?php
/**
 * NiceThemes Post Type API
 *
 * This file includes functions to handle this module's functionality.
 *
 * @package Nice_Testimonials_Post_Type_API
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create a new instance for this domain.
 *
 * @uses   nice_testimonials_create()
 *
 * @param  array $data
 *
 * @return Nice_Testimonials_Post_Type_Admin
 */
function nice_testimonials_post_type_admin_create( array $data ) {
	return nice_testimonials_create( 'Nice_Testimonials_Post_Type_Admin', $data );
}

/**
 * Obtain service for the current domain.
 *
 * @uses   nice_testimonials_service()
 *
 * @since  1.1
 *
 * @return Nice_Testimonials_Post_Type_AdminService
 */
function nice_testimonials_post_type_admin_service() {
	return nice_testimonials_service( 'Nice_Testimonials_Post_Type_Admin' );
}
