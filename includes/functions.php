<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * This file contains general helper functions.
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

if ( ! function_exists( 'nice_testimonials_post_type_name' ) ) :
/**
 * Name of main custom post type of this plugin.
 *
 * @since 1.0
 */
function nice_testimonials_post_type_name() {
	return apply_filters( 'nice_testimonials_post_type_name', 'testimonial' );
}
endif;

if ( ! function_exists( 'nice_testimonials_category_name' ) ) :
/**
 * Name of main taxonomy of this plugin.
 *
 * @since 1.0
 */
function nice_testimonials_category_name() {
	return apply_filters( 'nice_testimonials_category_name', 'testimonial_category' );
}
endif;

if ( ! function_exists( 'nice_testimonials_is_category' ) ) :
/**
 * Check if the current page is a testimonials category.
 *
 * @since 1.0
 *
 * @return mixed|string|bool
 */
function nice_testimonials_is_category() {
	// Check for a current testimonials category.
	$is_testimonials_category = nice_testimonials_get_current_category();

	// Allow overriding.
	$is_testimonials_category = apply_filters( 'nice_testimonials_is_category', $is_testimonials_category );

	return $is_testimonials_category;
}
endif;

if ( ! function_exists( 'nice_testimonials_get_category_id' ) ) :
/**
 * Obtain ID of current category.
 *
 * @since  1.0
 *
 * @return mixed|int|void
 */
function nice_testimonials_get_category_id() {
	// Allow bypassing.
	if ( $category_id = apply_filters( 'nice_testimonials_get_category_id', null ) ) {
		return $category_id;
	}

	// Obtain current term.
	$term = get_term_by( 'name', nice_testimonials_get_current_category(), nice_testimonials_category_name() );

	// Obtain ID from term.
	$category_id = ( $term instanceof stdClass ) ? $term->term_id : null;

	return $category_id;
}
endif;

if ( ! function_exists( 'nice_testimonials_get_current_category' ) ) :
/**
 * Obtain currently viewed category.
 *
 * @since  1.0
 * @return string
 */
function nice_testimonials_get_current_category() {
	$current_category = get_query_var( nice_testimonials_category_name(), false );
	$current_category = apply_filters( 'nice_testimonials_current_category', $current_category );

	return $current_category;
}
endif;
