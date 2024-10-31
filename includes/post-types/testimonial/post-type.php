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

if ( ! function_exists( 'nice_testimonials_get_post_type' ) ) :
add_filter( 'nice_testimonials_post_type', 'nice_testimonials_get_post_type' );
/**
 * Obtain values to construct the testimonials custom post type.
 *
 * This file is meant to ensure compatibility with content type standards.
 * {link https://github.com/justintadlock/content-type-standards}
 *
 * @since  1.0
 *
 * @return array
 */
function nice_testimonials_get_post_type() {
	$post_type_name = nice_testimonials_post_type_name();

	$labels = array(
		'name'               => esc_html__( 'Testimonials',                   'nice-testimonials' ),
		'singular_name'      => esc_html__( 'Testimonial',                    'nice-testimonials' ),
		'menu_name'          => esc_html__( 'Testimonials',                   'nice-testimonials' ),
		'name_admin_bar'     => esc_html__( 'Testimonial',                    'nice-testimonials' ),
		'add_new'            => esc_html__( 'Add New',                        'nice-testimonials' ),
		'add_new_item'       => esc_html__( 'Add New Testimonial',            'nice-testimonials' ),
		'edit_item'          => esc_html__( 'Edit Testimonial',               'nice-testimonials' ),
		'new_item'           => esc_html__( 'New Testimonial',                'nice-testimonials' ),
		'view_item'          => esc_html__( 'View Testimonial',               'nice-testimonials' ),
		'search_items'       => esc_html__( 'Search Testimonial',             'nice-testimonials' ),
		'not_found'          => esc_html__( 'No testimonials found',          'nice-testimonials' ),
		'not_found_in_trash' => esc_html__( 'No testimonials found in trash', 'nice-testimonials' ),
		'all_items'          => esc_html__( 'All Testimonials',               'nice-testimonials' ),
	);
	$labels = apply_filters( 'nice_testimonials_post_type_labels', $labels );

	$args = array(
		'menu_icon'           => 'dashicons-testimonial',
		'description'         => '',
		'public'              => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 14,
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => false,
		'query_var'           => $post_type_name,
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'page-attributes',
		),
	);
	$args = apply_filters( 'nice_testimonials_post_type_args', $args );

	$testimonials_post_type = array(
		'name'            => $post_type_name,
		'labels'          => $labels,
		'args'            => $args,
		'dashicons_glyph' => '\\f473',
	);

	return $testimonials_post_type;
}
endif;
