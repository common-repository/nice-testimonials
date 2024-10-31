<?php
/**
 * Nice Testimonials by NiceThemes.
 *
 * Register settings for Admin UI.
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

if ( ! function_exists( 'nice_testimonials_admin_ui_add_settings' ) ) :
add_filter( 'nice_testimonials_admin_ui_settings', 'nice_testimonials_admin_ui_add_settings' );
/**
 * Create tabs.
 *
 * @since 1.0
 */
function nice_testimonials_admin_ui_add_settings() {
	// Fields for General tab.
	$general_settings = array(
		'limit' => array(
			'id'          => 'limit',
			'title'       => esc_html__( 'Number of Testimonials', 'nice-testimonials' ),
			'description' => esc_html__( 'The number of testimonials to be displayed. A value of 0 (zero) means no testimonials will display. Use -1 (minus one) to display unlimited testimonials.', 'nice-testimonials' ) . ' ' . sprintf( esc_html__( 'You can override this setting in shortcodes using the %s property.', 'nice-testimonials' ), '<code>limit</code>' ),
			'type'        => 'text-small',
			'priority'    => 10,
		),
		'columns' => array(
			'id'          => 'columns',
			'title'       => esc_html__( 'Number of Columns', 'nice-testimonials' ),
			'description' => esc_html__( 'The number of columns for the testimonials.', 'nice-testimonials' ) . ' ' . sprintf( esc_html__( 'You can override this setting in shortcodes using the %s property.', 'nice-testimonials' ), '<code>columns</code>' ),
			'type'        => 'text-small',
			'priority'    => 20,
		),
		'image_size' => array(
			'id'          => 'image_size',
			'title'       => esc_html__( 'Size of Image (in pixels)', 'nice-testimonials' ),
			'description' => esc_html__( 'The size of your testimonial image.', 'nice-testimonials' ) . ' ' . sprintf( esc_html__( 'You can override this setting in shortcodes using the %s property.', 'nice-testimonials' ), '<code>image_size</code>' ),
			'type'        => 'text-small',
			'priority'    => 30,
		),
		'fields' => array(
			'id'          => 'fields',
			'title'       => esc_html__( 'Show Information', 'nice-testimonials' ),
			'description' => esc_html__( 'Select the information that should be displayed within a testimonial.', 'nice-testimonials' ),
			'type'        => 'checkbox-group',
			'options'     => array(
				'author'      => esc_html__( 'Author name', 'nice-testimonials' ),
				'avatar'      => esc_html__( 'Author image', 'nice-testimonials' ),
				'url'         => esc_html__( 'Author URL', 'nice-testimonials' ),
				'avatar_link' => esc_html__( 'Link to author URL from image', 'nice-testimonials' ),
			),
			'priority'    => 40,
		),
		'orderby' => array(
			'id'          => 'orderby',
			'title'       => esc_html__( 'Order items by', 'nice-testimonials' ),
			'description' => sprintf( esc_html__( 'You can override this setting in shortcodes using the %s property.', 'nice-testimonials' ), '<code>orderby</code>' ),
			'type'        => 'select',
			'options'     => array(
				'ID'         => esc_html__( 'Testimonial ID', 'nice-testimonials' ),
				'title'      => esc_html__( 'Title', 'nice-testimonials' ),
				'menu_order' => esc_html__( 'Menu Order', 'nice-testimonials' ),
				'date'       => esc_html__( 'Date', 'nice-testimonials' ),
				'random'     => esc_html__( 'Random Order', 'nice-testimonials' ),
			),
			'placeholder' => esc_html__( 'Select an option', 'nice-testimonials' ),
			'priority'    => 50,
		),
		'order' => array(
			'id'          => 'order',
			'title'       => esc_html__( 'Sort items by', 'nice-testimonials' ),
			'description' => sprintf( esc_html__( 'You can override this setting in shortcodes using the %s property.', 'nice-testimonials' ), '<code>order</code>' ),
			'type'        => 'select',
			'options'     => array(
				'asc'  => esc_html__( 'Ascending Order', 'nice-testimonials' ),
				'desc' => esc_html__( 'Descending Order', 'nice-testimonials' ),
			),
			'placeholder' => esc_html__( 'Select an option', 'nice-testimonials' ),
			'priority'    => 60,
		),
		'include_children' => array(
			'id'          => 'include_children',
			'title'       => esc_html__( 'Include Child Categories', 'nice-testimonials' ),
			'description' => esc_html__( 'Show children of parent categories.', 'nice-testimonials' ),
			'type'        => 'checkbox',
			'priority'    => 70,
		),
		'avoidcss' => array(
			'id'          => 'avoidcss',
			'title'       => esc_html__( 'Avoid Plugin CSS', 'nice-testimonials' ),
			'description' => esc_html__( 'Apply styles to testimonials elements using your own CSS.', 'nice-testimonials' ),
			'type'        => 'checkbox',
			'priority'    => 80,
		),
	);

	// Fields for Advanced tab.
	$advanced_settings = array(
		'remove_data_on_deactivation' => array(
			'id'          => 'remove_data_on_deactivation',
			'title'       => esc_html__( 'Remove Data On Deactivation', 'nice-testimonials' ),
			'description' => esc_html__( 'Delete all plugin settings once you deactivate it.', 'nice-testimonials' ),
			'type'        => 'checkbox',
			'priority'    => 0,
		),
	);

	// Construct settings array.
	$settings = array(
		'general' => array(
			'settings_section' => 'general-settings',
			'tab'              => 'general',
			'section'          => 'settings',
			'args'             => $general_settings,
		),
		'advanced' => array(
			'settings_section' => 'advanced-settings',
			'tab'              => 'advanced',
			'section'          => 'settings',
			'args'             => $advanced_settings,
		),
	);

	return $settings;
}
endif;
