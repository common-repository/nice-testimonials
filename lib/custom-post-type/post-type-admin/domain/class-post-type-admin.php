<?php
/**
 * NiceThemes Post Type API
 *
 * @package Nice_Testimonials_Post_Type_API
 * @license GPL-2.0+
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Nice_Testimonials_Post_Type_Admin' ) ) :
/**
 * Register post types and taxonomies.
 *
 * @package Nice_Testimonials_Post_Type
 * @since   1.1
 */
class Nice_Testimonials_Post_Type_Admin extends Nice_Testimonials_Entity {
	/**
	 * Registered post type object.
	 *
	 * @var Nice_Testimonials_Post_Type
	 */
	protected $post_type;

	/**
	 * Data for Dashboard at a Glance.
	 *
	 * @var   Nice_Testimonials_Glancer
	 * @since 1.1
	 */
	protected $glancer;

	/**
	 * Text domain for this class.
	 *
	 * @var  string
	 * since 1.1
	 */
	protected $textdomain = 'nice-testimonials-post-type-admin';
}
endif;
