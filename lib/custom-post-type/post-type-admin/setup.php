<?php
/**
 * NiceThemes Post Type API
 *
 * This file hooks processes to internal actions within this domain.
 *
 * @package Nice_Testimonials_Post_Type
 * @license GPL-2.0+
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fire the display action for this domain once a post type has been created.
 *
 * @since 1.0
 *
 * @uses  nice_testimonials_display()
 *
 * Hook origin:
 * @see Nice_Testimonials_Post_Type_AdminCreateResponder::loaded()
 */
add_action( 'nice_testimonials_post_type_admin_created', 'nice_testimonials_display' );

/**
 * Set the glancer for a created post type.
 *
 * @since 1.0
 *
 * @uses  Nice_Testimonials_Post_Type_AdminService::set_glancer()
 *
 * Hook origin:
 * @see Nice_Testimonials_Post_Type_AdminCreateResponder::loaded()
 */
add_action( 'nice_testimonials_post_type_admin_created', array( 'Nice_Testimonials_Post_Type_AdminService', 'set_glancer' ) );
