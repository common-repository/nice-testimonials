<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * This file contains hooks to handle the `testimonial` post type in the
 * admin-facing side of the plugin.
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

if ( ! function_exists( 'nice_testimonials_relocate_image' ) ) :
add_filter( 'nice_testimonials_post_type_add_image_column', 'nice_testimonials_relocate_image' );
/**
 * Move featured image to the first column in the list of testimonials items.
 *
 * @since 1.0
 *
 * @param  array $columns
 * @return array
 */
function nice_testimonials_relocate_image( $columns ) {
	if ( nice_testimonials_doing_ajax() && isset( $_POST['post_ID'] ) ) { // WPCS: CSRF ok.
		$post_type = get_post_type( intval( $_POST['post_ID'] ) ); // WPCS: CSRF ok.
	}

	if ( empty( $post_type ) ) {
		$post_type = get_query_var( 'post_type' );
	}

	if ( empty( $post_type ) ) {
		return $columns;
	}

	if ( isset( $columns['thumbnail'] ) && nice_testimonials_post_type_name() === $post_type ) {
		// Store the original key and value for the thumbnail.
		$new_columns['thumbnail'] = $columns['thumbnail'];

		// Remove value from original array.
		unset( $columns['thumbnail'] );

		// Divide the original array in two by the necessary position.
		$f = array_splice( $columns, 0, array_search( 'cb', array_keys( $columns ) ) + 1 );

		// Put the parts together again as needed.
		$columns = array_merge( $f, $new_columns, $columns );
	}
	$columns = apply_filters( 'nice_testimonials_relocate_image', $columns );

	return $columns;
}
endif;

if ( ! function_exists( 'nice_testimonials_post_updated_messages' ) ) :
add_filter( 'post_updated_messages', 'nice_testimonials_post_updated_messages' );
/**
 * Add custom messages after updating a testimonial.
 *
 * @since  1.0
 *
 * @param  array $messages
 * @return array
 */
function nice_testimonials_post_updated_messages( $messages ) {
	global $post;

	$post_type_name = nice_testimonials_post_type_name();

	if ( $post_type_name === $post->post_type ) {
		$testimonial_updated_messages = array(
			0  => '', // Unused. Messages start at index 1.
			1  => sprintf(
				esc_html__( 'Testimonial updated.', 'nice-testimonials' ),
				esc_url( get_permalink( $post->ID ) )
			),
			2  => esc_html__( 'Custom field updated.', 'nice-testimonials' ),
			3  => esc_html__( 'Custom field deleted.', 'nice-testimonials' ),
			4  => esc_html__( 'Testimonial updated.', 'nice-testimonials' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Testimonial restored to revision from %s', 'nice-testimonials' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => esc_html__( 'Testimonial published.', 'nice-testimonials' ),
			7  => esc_html__( 'Testimonial saved.', 'nice-testimonials' ),
			8  => esc_html__( 'Testimonial submitted.', 'nice-testimonials' ),
			9  => sprintf(
				wp_kses( __( 'Testimonial scheduled for: <strong>%1$s</strong>.', 'nice-testimonials' ), array( 'strong' => array() ) ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( esc_html__( 'M j, Y @ G:i', 'nice-testimonials' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post->ID ) )
			),
			10 => esc_html__( 'Testimonial draft updated.', 'nice-testimonials' ),
		);
		$testimonial_updated_messages = apply_filters(
			'nice_testimonials_post_updated_messages',
			$testimonial_updated_messages
		);

		$messages[ $post_type_name ] = $testimonial_updated_messages;
	}

	return $messages;
}
endif;
