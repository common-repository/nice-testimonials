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

if ( ! function_exists( 'nice_testimonials_get_category' ) ) :
add_filter( 'nice_testimonials_category', 'nice_testimonials_get_category' );
/**
 * Obtain values to construct the category for testimonials post type.
 *
 * This method is meant to ensure compatibility with content type standards.
 * {link https://github.com/justintadlock/content-type-standards}
 *
 * @since  1.0
 *
 * @return array
 */
function nice_testimonials_get_category() {
	$category_name = nice_testimonials_category_name();

	$labels = array(
		'name'                       => esc_html__( 'Testimonial Categories', 'nice-testimonials' ),
		'singular_name'              => esc_html__( 'Testimonial Category',   'nice-testimonials' ),
		'menu_name'                  => esc_html__( 'Categories',             'nice-testimonials' ),
		'name_admin_bar'             => esc_html__( 'Category',               'nice-testimonials' ),
		'search_items'               => esc_html__( 'Search Categories',      'nice-testimonials' ),
		'popular_items'              => esc_html__( 'Popular Categories',     'nice-testimonials' ),
		'all_items'                  => esc_html__( 'All Categories',         'nice-testimonials' ),
		'edit_item'                  => esc_html__( 'Edit Category',          'nice-testimonials' ),
		'view_item'                  => esc_html__( 'View Category',          'nice-testimonials' ),
		'update_item'                => esc_html__( 'Update Category',        'nice-testimonials' ),
		'add_new_item'               => esc_html__( 'Add New Category',       'nice-testimonials' ),
		'new_item_name'              => esc_html__( 'New Category Name',      'nice-testimonials' ),
		'parent_item'                => esc_html__( 'Parent Category',        'nice-testimonials' ),
		'parent_item_colon'          => esc_html__( 'Parent Category:',       'nice-testimonials' ),
		'separate_items_with_commas' => null,
		'add_or_remove_items'        => null,
		'choose_from_most_used'      => null,
		'not_found'                  => null,
	);
	$labels = apply_filters( 'nice_testimonials_category_labels', $labels );

	$args = array(
		'public'            => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'query_var'         => $category_name,
	);
	$args = apply_filters( 'nice_testimonials_category_args', $args );

	$testimonials_category = array(
		'name'   => $category_name,
		'labels' => $labels,
		'args'   => $args,
	);

	return $testimonials_category;
}
endif;
