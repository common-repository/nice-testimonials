<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * @package   Nice_Testimonials
 * @author    NiceThemes <hello@nicethemes.com>
 * @license   GPL-2.0+
 * @link      https://nicethemes.com/product/nice-testimonials
 * @copyright 2016-2017 NiceThemes
 *
 * @wordpress-plugin
 * Plugin Name:       Nice Testimonials
 * Plugin URI:        https://nicethemes.com/product/nice-testimonials
 * Description:       Show testimonials from your customers in your WordPress site in a beautiful and organized way.
 * Version:           1.0.2
 * Author:            NiceThemes
 * Author URI:        http://nicethemes.com
 * Contributors:      nicethemes, juanfra, andrezrv
 * Text Domain:       nice-testimonials
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/nicethemes/nice-testimonials
 * NiceThemes-Plugin-Boilerplate: v1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Load a file for development purposes if we have one.
 *
 * This is useful for plugin developers and users that want to test things
 * without breaking the rest of the codebase.
 *
 * @since 1.0
 */
if ( file_exists( $develop = plugin_dir_path( __FILE__ ) . 'develop.php' ) ) {
	include $develop;
}

/**
 * Define plugin file.
 */
if ( ! defined( 'NICE_TESTIMONIALS_PLUGIN_FILE' ) ) {
	define( 'NICE_TESTIMONIALS_PLUGIN_FILE', __FILE__ );
}

/**
 * Define plugin domain.
 */
if ( ! defined( 'NICE_TESTIMONIALS_PLUGIN_DOMAIN_FILE' ) ) {
	define( 'NICE_TESTIMONIALS_PLUGIN_DOMAIN_FILE', __FILE__ );
}

/**
 * Define URL for admin assets.
 */
if ( ! defined( 'NICE_TESTIMONIALS_ADMIN_ASSETS_URL' ) ) {
	define( 'NICE_TESTIMONIALS_ADMIN_ASSETS_URL', trailingslashit( plugins_url( 'admin/assets', __FILE__ ) ) );
}

/**
 * Load file for plugin initialization.
 */
require plugin_dir_path( __FILE__ ) . 'init.php';

/**
 * Trigger plugin functionality.
 *
 * @since 1.0
 */
do_action( 'nice_testimonials_plugin_do' );
