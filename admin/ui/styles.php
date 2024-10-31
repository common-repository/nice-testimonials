<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Extra styles for Admin UI.
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

if ( ! function_exists( 'nice_testimonials_admin_ui_add_style' ) ) :
add_filter( 'nice_testimonials_admin_ui_style_extra', 'nice_testimonials_admin_ui_add_style' );
/**
 * Add custom CSS file to Admin UI.
 *
 * @since 1.0
 */
function nice_testimonials_admin_ui_add_style() {
	$url = plugin_dir_url( __FILE__ ) . '../assets/css/nice-testimonials-admin-ui.css';
	$url = nice_testimonials_canonicalize_url( $url );

	return $url;
}
endif;
