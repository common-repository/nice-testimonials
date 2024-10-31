<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Create action links for plugin entry in plugins page.
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

if ( ! function_exists( 'nice_testimonials_admin_action_links' ) ) :
add_filter( 'nice_testimonials_admin_action_links', 'nice_testimonials_admin_action_links' );
/**
 * Add settings action link to the plugins page.
 *
 * @since  1.0
 *
 * @param  array $links Current list of action links.
 * @return array
 */
function nice_testimonials_admin_action_links( $links ) {
	// Return early if we're in an AJAX context.
	if ( nice_testimonials_doing_ajax() ) {
		return null;
	}

	// Set values for link components.
	$url = admin_url( 'edit.php?post_type=' . nice_testimonials_post_type_name() . '&page=' . nice_testimonials_plugin_slug() );
	$text = esc_html__( 'Settings', 'nice-testimonials' );

	// List new links to be introduced.
	$new_links = array(
		'settings' => '<a href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a>',
	);
	$new_links = apply_filters( 'nice_testimonials_admin_new_action_links', $new_links );

	$links = array_merge( $new_links, $links );

	return $links;
}
endif;
