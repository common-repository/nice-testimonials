<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * This file handles functionality related to plugin settings.
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

if ( ! function_exists( 'nice_testimonials_set_default_settings' ) ) :
add_filter( 'nice_testimonials_default_settings', 'nice_testimonials_set_default_settings' );
/**
 * Set default plugin settings.
 *
 * @see    nice_testimonials_default_settings()
 *
 * @since  1.0
 *
 * @return array
 */
function nice_testimonials_set_default_settings() {
	$defaults = array(
		'remove_data_on_deactivation' => false,
		'limit'                       => get_option( 'posts_per_page' ),
		'columns'                     => 3,
		'image_size'                  => 96,
		'orderby'                     => 'id',
		'order'                       => 'desc',
		'avoidcss'                    => false,
		'include_children'            => true,
		'fields'                      => array(
			'author'      => 1,
			'avatar'      => 1,
			'url'         => 1,
			'avatar_link' => 1,
		),
	);

	return $defaults;
}
endif;
