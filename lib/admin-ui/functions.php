<?php
/**
 * NiceThemes Admin UI
 *
 * This file contains general helper functions that allow interactions with
 * this module in an easier way.
 *
 * @package Nice_Testimonials_Admin_UI
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return service for the current domain.
 *
 * @uses   nice_testimonials_service()
 *
 * @since  1.0
 *
 * @return Nice_Testimonials_Admin_UIService
 */
function nice_testimonials_admin_ui_service() {
	return nice_testimonials_service( 'Nice_Testimonials_Admin_UI' );
}

/**
 * Process registrations on an instance with given data.
 *
 * @since 1.0
 *
 * @param Nice_Testimonials_Admin_UI $ui
 * @param array $data
 */
function nice_testimonials_admin_ui_register( Nice_Testimonials_Admin_UI $ui, array $data = array() ) {
	nice_testimonials_request( 'Nice_Testimonials_Admin_UI', 'register', array_merge( $data, array(
			'instance' => $ui,
		)
	) );
}

/**
 * Check if we're running on the MP6 UI.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_testimonials_admin_ui_is_mp6() {
	global $wp_version;

	return ( version_compare( $wp_version, '3.8', '>=' ) || defined( 'MP6' ) );
}
