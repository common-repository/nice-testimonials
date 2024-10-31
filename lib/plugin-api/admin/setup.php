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

if ( is_admin() ) :

/**
 * Set templates path for the admin instance.
 *
 * @since 1.0
 *
 * @uses  Nice_Testimonials_AdminService::set_templates_path()
 *
 * Hook origin:
 * @see nice_testimonials_plugin_admin_init()
 */
add_action( 'nice_testimonials_plugin_admin_after_init', array( 'Nice_Testimonials_AdminService', 'set_templates_path' ), 10 );

/**
 * Set an Admin UI for our admin instance once it has been created.
 *
 * @since 1.0
 *
 * @uses  Nice_Testimonials_AdminService::set_admin_ui()
 *
 * Hook origin:
 * @see nice_testimonials_plugin_admin_init()
 */
add_action( 'nice_testimonials_plugin_admin_after_init', array( 'Nice_Testimonials_AdminService', 'set_admin_ui' ), 20 );

/**
 * Set admin pointers once the admin instance has been created.
 *
 * @since 1.0
 *
 * @uses  Nice_Testimonials_AdminService::set_pointer_collection()
 *
 * Hook origin:
 * @see nice_testimonials_plugin_admin_init()
 */
add_action( 'nice_testimonials_plugin_admin_after_init', array( 'Nice_Testimonials_AdminService', 'set_pointer_collection' ), 30 );

/**
 * Schedule admin visual elements to be displayed.
 *
 * @since 1.0
 *
 * @uses  nice_testimonials_display()
 *
 * Hook origin:
 * @see nice_testimonials_plugin_admin_init()
 */
add_action( 'nice_testimonials_plugin_admin_after_init', 'nice_testimonials_display', 40 );

/**
 * Update Admin UI sections using external data from plugins and/or themes.
 *
 * @since 1.0
 *
 * @uses  Nice_Testimonials_AdminService::register_admin_ui_sections()
 *
 * Hook origin:
 * @see wp-settings.php
 */
add_action( 'after_setup_theme', array( 'Nice_Testimonials_AdminService', 'register_admin_ui_sections' ), 10 );

/**
 * Update extra Admin UI elements using external data from plugins and/or themes.
 *
 * @since 1.0
 *
 * @uses  Nice_Testimonials_AdminService::register_admin_ui_extra
 *
 * Hook origin:
 * @see wp-settings.php
 */
add_action( 'after_setup_theme', array( 'Nice_Testimonials_AdminService', 'register_admin_ui_extra' ), 20 );

/**
 * Create pointers to be associated with the pointer collection of our admin
 * instance.
 *
 * @since 1.0
 *
 * @uses nice_testimonials_add_pointers()
 *
 * Hook origin:
 * @see Nice_Testimonials_AdminService::get_pointer_collection()
 */
add_filter( 'nice_testimonials_admin_pointers', 'nice_testimonials_add_pointers', 10, 2 );

/**
 * Set pointer collection for our admin instance.
 *
 * @since 1.0
 *
 * @uses nice_testimonials_process_pointer_collection()
 *
 * Hook origin:
 * @see Nice_Testimonials_AdminService::get_pointer_collection()
 */
add_filter( 'nice_testimonials_admin_pointer_collection', 'nice_testimonials_process_pointer_collection', 10, 2 );

/**
 * Set post types for admin instance.
 *
 * The priority of this hook is set to 20 to make sure post types are already
 * initialized when their admin-side functionality fires.
 *
 * @since 1.0
 *
 * @uses  Nice_Testimonials_AdminService::set_post_types()
 *
 * Hook origin:
 * @see ./wp-settings.php
 */
add_action( 'after_setup_theme', array( 'Nice_Testimonials_AdminService', 'set_post_types' ), 20 );

/**
 * Set metaboxes for admin instance using external data from plugins and/or themes.
 *
 * @since 1.0
 *
 * @uses  Nice_Testimonials_AdminService::set_metaboxes()
 *
 * Hook origin:
 * @see ./wp-settings.php
 */
add_action( 'after_setup_theme', array( 'Nice_Testimonials_AdminService', 'set_metaboxes' ), 30 );

endif;
