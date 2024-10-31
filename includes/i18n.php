<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Manage functionality for localization features.
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

/**
 * The following strings define translatable data that's not tied to any
 * particular output.
 *
 * @since 1.0
 */
$nice_testimonials_i18n_plugin_data = array(
	'plugin_name'        => esc_html__( 'Nice Testimonials', 'nice-testimonials' ),
	'plugin_name_author' => esc_html__( 'Nice Testimonials By NiceThemes', 'nice-testimonials' ),
	'plugin_description' => esc_html__( 'Show testimonials from your customers in your WordPress site in a beautiful and organized way.', 'nice-testimonials' ),
);

add_filter( 'nice_testimonials_plugin_i18n_data', 'nice_testimonials_plugin_i18_domain_path' );
/**
 * Set the right location of language files.
 *
 * @since  1.0
 *
 * @param  array $data
 *
 * @return array
 */
function nice_testimonials_plugin_i18_domain_path( array $data = array() ) {
	return array_merge( $data, array(
			'path' => nice_testimonials_plugin_domain() . 'languages',
		)
	);
}
