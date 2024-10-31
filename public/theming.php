<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * This file manages basic theme customizations.
 *
 * @package Nice_Testimonials
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_testimonials_do' ) ) :
add_action( 'init', 'nice_testimonials_do' );
/**
 * Add hooks to the `nice_testimonials` action.
 *
 * @since 1.0.0
 */
function nice_testimonials_do() {
	add_action( 'nice_testimonials', 'nice_testimonials' );
}
endif;
