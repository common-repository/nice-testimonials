<?php
/**
 * NiceThemes Plugin API
 *
 * This file hooks processes to internal actions within this domain.
 *
 * @package Nice_Testimonials_Plugin
 * @license GPL-2.0+
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fire the display action for this domain once the public instance has been
 * fully initialized.
 *
 * @since 1.0
 *
 * @uses  nice_testimonials_display()
 *
 * Hook origin:
 * @see nice_testimonials_plugin_public_init()
 */
add_action( 'nice_testimonials_plugin_public_after_init', 'nice_testimonials_display', 10 );
