<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Enqueue styles for admin-facing side.
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

if ( ! function_exists( 'nice_testimonials_admin_enqueue_styles' ) ) :
add_action( 'admin_enqueue_scripts', 'nice_testimonials_admin_enqueue_styles' );
/**
 * Register and enqueue admin-specific stylesheet.
 *
 * @since 1.0
 */
function nice_testimonials_admin_enqueue_styles() {
	$screen = get_current_screen();

	if ( nice_testimonials_post_type_name() === $screen->post_type ) {
		$stylesheet_url = plugins_url( 'assets/css/nice-testimonials-admin.css', __FILE__ );

		wp_enqueue_style(
			nice_testimonials_plugin_slug() . '-admin-styles',
			nice_testimonials_canonicalize_url( $stylesheet_url ),
			array(),
			nice_testimonials_plugin_version()
		);
	}
}
endif;
