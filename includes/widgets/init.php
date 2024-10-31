<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Register widgets for this plugin.
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

if ( ! function_exists( 'nice_testimonials_register_widgets' ) ) :
add_action( 'widgets_init', 'nice_testimonials_register_widgets' );
/**
 * Register widgets for this plugin.
 *
 * @since 1.0
 */
function nice_testimonials_register_widgets() {
	/**
	 * @hook nice_testimonials_enable_widget_testimonials
	 *
	 * Hook here if you don't want to register this widget.
	 *
	 * @since 1.0
	 */
	if ( apply_filters( 'nice_testimonials_enable_widget_testimonials', true ) ) {
		/**
		 * Testimonials.
		 *
		 * @since 1.0
		 */
		register_widget( 'Nice_Testimonials_Widget' );
	}
}
endif;

if ( ! function_exists( 'nice_testimonials_widget_loaded' ) ) :
add_action( 'nice_testimonials_widget_loaded', 'nice_testimonials_widget_loaded' );
/**
 * Schedule hooks when the Testimonials widget is loaded.
 *
 * @since 1.0
 *
 * @param Nice_Testimonials_Widget $widget Current instance of widget object.
 */
function nice_testimonials_widget_loaded( Nice_Testimonials_Widget $widget ) {
	add_action( 'switch_theme', array( $widget->{'cache'}, 'flush' ) );
}
endif;

if ( ! function_exists( 'nice_testimonials_widget_public_loaded' ) ) :
add_action( 'nice_testimonials_widget_public_loaded', 'nice_testimonials_widget_public_loaded' );
/**
 * Schedule hooks when the Testimonials widget is displayed in the front end.
 *
 * @since 1.0
 */
function nice_testimonials_widget_public_loaded() {
	$settings = nice_testimonials_settings();

	/**
	 * Load assets when Testimonials widget needs to be displayed.
	 */
	if ( ! $settings['avoidcss'] ) {
		add_filter( 'nice_testimonials_needs_assets', '__return_true' );
	}
}
endif;

if ( ! function_exists( '_nice_testimonials_doing_widget' ) ) :
/**
 * Set and check if a widget is being processed.
 *
 * @internal
 *
 * @since 1.0
 *
 * @param  mixed|bool|null $flag
 * @return bool
 */
function _nice_testimonials_doing_widget( $flag = null ) {
	static $doing_widget = false;

	if ( is_bool( $flag ) ) {
		$doing_widget = $flag;
	}

	return $doing_widget;
}
endif;
