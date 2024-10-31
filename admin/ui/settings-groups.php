<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Register groups of settings for Admin UI.
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

if ( ! function_exists( 'nice_testimonials_admin_ui_add_settings_groups' ) ) :
add_filter( 'nice_testimonials_admin_ui_settings_groups', 'nice_testimonials_admin_ui_add_settings_groups' );
/**
 * Create groups of settings.
 *
 * @since 1.0
 */
function nice_testimonials_admin_ui_add_settings_groups() {
	$general_settings = array(
		'general-settings' => array(
			'title'       => esc_html__( 'General Settings', 'nice-testimonials' ),
			'description' => esc_html__( 'Configure how your testimonials will be displayed by default. All these options can be overridden in a shortcode basis.', 'nice-testimonials' ),
		),
	);

	$advanced_settings = array(
		'advanced-settings' => array(
			'title'       => esc_html__( 'Advanced Settings', 'nice-testimonials' ),
			'description' => esc_html__( 'Options presented here are for advanced users only, so you must use them carefully.', 'nice-testimonials' ),
		),
	);

	$settings_groups = array(
		array(
			'tab'     => 'general',
			'section' => 'settings',
			'args'    => $general_settings,
		),
		array(
			'tab'     => 'advanced',
			'section' => 'settings',
			'args'    => $advanced_settings,
		),
	);

	return $settings_groups;
}
endif;
