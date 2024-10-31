<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Fire main plugin functionality.
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

add_action( 'nice_testimonials_plugin_do', 'nice_testimonials_plugin_do' );
/**
 * Trigger plugin functionality.
 *
 * @since 1.0
 */
function nice_testimonials_plugin_do() {
	/**
	 * Obtain path to current folder.
	 */
	$plugin_dir_path = plugin_dir_path( __FILE__ );

	/**
	 * Load Plugin API.
	 */
	require $plugin_dir_path . 'lib/nice-adr/bootstrap.php';

	/**
	 * Load hooks for required libraries.
	 */
	require $plugin_dir_path . 'required.php';

	/**
	 * Load dependencies.
	 */
	nice_testimonials_autoload( $plugin_dir_path . 'lib' );
}
