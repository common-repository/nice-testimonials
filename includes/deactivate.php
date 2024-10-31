<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * This file handles processes that fire on plugin deactivation.
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

if ( ! function_exists( 'nice_testimonials_remove_settings' ) ) :
add_action( 'nice_testimonials_deactivate', 'nice_testimonials_remove_settings' );
/**
 * Remove settings on plugin deactivation.
 *
 * @since 1.0
 */
function nice_testimonials_remove_settings() {
	/**
	 * Remove plugin data only if requested.
	 */
	$settings = nice_testimonials_settings();

	if ( ! empty( $settings['remove_data_on_deactivation'] )  && $settings['remove_data_on_deactivation'] ) {
		/**
		 * Remove settings holder.
		 */
		delete_option( nice_testimonials_settings_name() );
	}
}
endif;
