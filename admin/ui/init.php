<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Initialize Admin UI.
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

if ( ! function_exists( 'nice_testimonials_admin_ui' ) ) :
add_filter( 'nice_testimonials_admin_ui_data', 'nice_testimonials_admin_ui' );
/**
 * Create a new Admin UI.
 *
 * @since 1.0
 */
function nice_testimonials_admin_ui() {
	$admin_ui = array(
		'submenu_parent_slug' => 'edit.php?post_type=' . nice_testimonials_post_type_name(),
		'name'                => nice_testimonials_plugin_slug(),
		'title'               => esc_html__( 'Settings', 'nice-testimonials' ),
		'textdomain'          => 'nice-testimonials',
		'settings_name'       => nice_testimonials_settings_name(),
		'templates_path'      => plugin_dir_path( __FILE__ ) . 'templates/',
	);

	return $admin_ui;
}
endif;
