<?php
/**
 * Nice Testimonials by NiceThemes.
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

if ( ! function_exists( 'nice_testimonials_register_meta' ) ) :
add_action( 'nice_testimonials_admin_loaded', 'nice_testimonials_register_meta' );
/**
 * Register post meta fields.
 *
 * @since 1.0
 */
function nice_testimonials_register_meta() {
	register_meta( 'post', '_testimonial_url',              'esc_url_raw',         '__return_true' );
	register_meta( 'post', '_testimonial_url_target_blank', 'sanitize_text_field', '__return_true' );
	register_meta( 'post', '_testimonial_email',            'sanitize_text_field', '__return_true' );
	register_meta( 'post', '_testimonial_byline',           'sanitize_text_field', '__return_true' );
}
endif;

if ( ! function_exists( 'nice_testimonials_create_metabox_info' ) ) :
add_filter( 'nice_testimonials_metaboxes', 'nice_testimonials_create_metabox_info' );
/**
 * Create a metabox for our custom post type.
 *
 * @since  1.0
 *
 * @param  array $metaboxes List of current metaboxes.
 *
 * @return array
 */
function nice_testimonials_create_metabox_info( array $metaboxes ) {
	// Define post types.
	$post_types = array( nice_testimonials_post_type_name() );
	$post_types = apply_filters( 'nice_testimonials_metabox_info_post_types', $post_types );

	// Define testimonial URL.
	$url = array(
		'type'  => 'text',
		'label' => esc_html__( 'Customer\'s URL', 'nice-testimonials' ),
		'name'  => '_testimonial_url',
		'desc'  => esc_html__( 'Link to the customer\'s website (optional).', 'nice-testimonials' ),
	);
	$url = apply_filters( 'nice_testimonials_metabox_url', $url );

	// Define link target blank field.
	$target_blank = array(
		'type'  => 'checkbox',
		'label' => esc_html__( 'Open in a new window/tab', 'nice-testimonials' ),
		'name'  => '_testimonial_url_target_blank',
		'desc'  => esc_html__( 'Tick this option if you want the customer\'s link to be opened in a new window/tab (optional).', 'nice-testimonials' ),
	);
	$target_blank = apply_filters( 'nice_testimonials_metabox_url_target_blank', $target_blank );

	// Define testimonial email for Gravatar.
	$email = array(
		'type'  => 'text',
		'label' => esc_html__( 'Customer\'s Email', 'nice-testimonials' ),
		'name'  => '_testimonial_email',
		'desc'  => esc_html__( 'Email address to show the customer\'s avatar from Gravatar (optional). If not set, we\'ll use the featured image instead.', 'nice-testimonials' ),
	);
	$email = apply_filters( 'nice_testimonials_metabox_email', $email );

	// Define byline.
	$byline = array(
		'type'  => 'text',
		'label' => esc_html__( 'Customer\'s Byline', 'nice-testimonials' ),
		'name'  => '_testimonial_byline',
		'desc'  => esc_html__( 'Enter here the customer\'s position.', 'nice-testimonials' ),
	);
	$byline = apply_filters( 'nice_testimonials_metabox_byline', $byline );

	// Group all fields.
	$fields = array(
		$url,
		$target_blank,
		$email,
		$byline,
	);
	$fields = apply_filters( 'nice_testimonials_metabox_info_fields', $fields );

	// Define meta box settings.
	$settings = array(
		'title' => esc_html__( 'Testimonial Details', 'nice-testimonials' ),
	);
	$settings = apply_filters( 'nice_testimonials_metabox_info_settings', $settings );

	// Prepare arguments.
	$args = array(
		'id'         => 'nice-testimonials-post-details',
		'post_types' => $post_types,
		'fields'     => $fields,
		'settings'   => $settings,
	);

	$metaboxes[] = apply_filters( 'nice_testimonials_metabox_info_args', $args );

	return $metaboxes;
}
endif;

if ( ! function_exists( 'nice_testimonials_post_title_placeholder_text' ) ) :
add_filter( 'enter_title_here', 'nice_testimonials_post_title_placeholder_text', 20 );
/**
 * Modify the default placeholder for testimonials in the editor.
 *
 * @param $title
 *
 * @return string|void
 */
function nice_testimonials_post_title_placeholder_text( $title ) {
	$screen = get_current_screen();

	if ( nice_testimonials_post_type_name() === $screen->post_type ) {
		$title = esc_html__( 'Enter the customer\'s name here', 'nice-testimonials' );
	}

	return $title;
}
endif;

if ( ! function_exists( 'nice_testimonials_thumbnail_meta_box_html_title' ) ) :
add_action( 'add_meta_boxes', 'nice_testimonials_thumbnail_meta_box_html_title' );
/**
 * Modify the title of the Featured Image meta box.
 *
 * @since  1.0
 */
function nice_testimonials_thumbnail_meta_box_html_title() {
	global $wp_meta_boxes;

	$wp_meta_boxes[ nice_testimonials_post_type_name() ]['side']['low']['postimagediv']['title'] = esc_html__( 'Customer\'s image', 'nice-testimonials' );
}
endif;

if ( ! function_exists( 'nice_testimonials_thumbnail_meta_box_html' ) ) :
add_filter( 'admin_post_thumbnail_html', 'nice_testimonials_thumbnail_meta_box_html' );
/**
 * Modify the output of the Featured Image meta box.
 *
 * @since  1.0
 *
 * @param  string      $content
 * @return string|void
 */
function nice_testimonials_thumbnail_meta_box_html( $content ) {
	global $typenow;

	$post_type = $typenow;

	$post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : null; // WPCS: CSRF ok.

	if ( ! $post_type ) {
		$post = ( $p = get_post() ) ? $p : get_post( $post_id );
		$post_type = $post->post_type;
	}

	if ( nice_testimonials_post_type_name() === $post_type ) {
		$content = str_replace(
			esc_html__( 'Set featured image', 'nice-testimonials' ),
			esc_html__( 'Set customer\'s image', 'nice-testimonials' ),
			$content
		);

		$content = str_replace(
			esc_html__( 'Remove featured image', 'nice-testimonials' ),
			esc_html__( 'Remove customer\'s image', 'nice-testimonials' ),
			$content
		);
	}
	$content = apply_filters( 'nice_testimonials_thumbnail_meta_box_html', $content );

	return $content;
}
endif;

if ( ! function_exists( 'nice_testimonials_media_view_strings' ) ) :
add_filter( 'media_view_strings', 'nice_testimonials_media_view_strings' );
/**
 * Modify strings for media uploader localization.
 *
 * @since  1.0.0
 *
 * @param  array $strings List of localized strings.
 *
 * @return array
 */
function nice_testimonials_media_view_strings( array $strings = array() ) {
	global $typenow;

	$post_type = $typenow;
	$post_id   = ! empty( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0; // WPCS: CSRF ok.

	if ( ! $post_type ) {
		$post = ( $p = get_post() ) ? $p : get_post( $post_id );

		if ( ! $post ) {
			return $strings;
		}

		$post_type = $post->post_type;
	}

	if ( nice_testimonials_post_type_name() === $post_type ) {
		$strings = array_merge( $strings, array(
				'setFeaturedImage'      => esc_html__( 'Set Customer\'s Image', 'nice-testimonials' ),
				'setFeaturedImageTitle' => esc_html__( 'Set Customer\'s Image', 'nice-testimonials' ),
			)
		);
	}

	return $strings;
}
endif;
