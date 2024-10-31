<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * This file includes actions to handle styles for the public-facing side of
 * the plugin.
 *
 * @package Nice_Testimonials
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_testimonials_enqueue_styles' ) ) :
add_action( 'nice_testimonials_plugin_enqueue_styles', 'nice_testimonials_enqueue_styles' );
/**
 * Enqueue styles for testimonials.
 *
 * @since 1.0
 */
function nice_testimonials_enqueue_styles() {
	if ( nice_testimonials_needs_assets() ) {
		// Enqueue testimonials styles.
		wp_enqueue_style(
			nice_testimonials_plugin_slug() . '-styles',
			nice_testimonials_canonicalize_url( plugins_url( 'assets/css/nice-testimonials.css', __FILE__ ) ),
			array(),
			nice_testimonials_plugin_version()
		);
	}
}
endif;
