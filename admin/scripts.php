<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Enqueue scripts for admin-facing side.
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

if ( ! function_exists( 'nice_testimonials_admin_enqueue_scripts' ) ) :
add_action( 'nice_testimonials_admin_enqueue_scripts', 'nice_testimonials_admin_enqueue_scripts' );
/**
 * Register and enqueue admin-specific JavaScript.
 *
 * @since 1.0
 */
function nice_testimonials_admin_enqueue_scripts() {
	// Obtain plugin slug and version.
	$slug    = nice_testimonials_plugin_slug();
	$version = nice_testimonials_plugin_version();

	// Obtain whether or not we're in debug mode.
	$debug = ( nice_testimonials_debug() || nice_testimonials_development_mode() );

	// Define script URLs.
	$scripts = array(
		$slug . '-admin-notices-script' => NICE_TESTIMONIALS_ADMIN_ASSETS_URL . ( $debug ? 'js/nice-testimonials-admin-notices.js' : 'js/min/nice-testimonials-admin-notices.min.js' ),
	);

	/**
	 * Admin notices script.
	 */
	if ( nice_testimonials_admin_is_update_notice_enabled() ) {
		wp_register_script( $slug . '-admin-notices-script', $scripts[ $slug . '-admin-notices-script' ], array( 'jquery' ), $version );
		wp_enqueue_script( $slug . '-admin-notices-script' );

		wp_localize_script( $slug . '-admin-notices-script', 'nice_testimonials_admin_notices_vars', array(
			'ajax_url' => admin_url() . 'admin-ajax.php',
			'nonce'    => wp_create_nonce( 'nice-testimonials-admin-notices-nonce' ),
		) );
	}
}
endif;
