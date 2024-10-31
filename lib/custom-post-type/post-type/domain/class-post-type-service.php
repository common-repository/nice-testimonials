<?php
/**
 * NiceThemes Post Type API
 *
 * @package Nice_Testimonials_Post_Type_API
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Testimonials_Post_Type_Service
 *
 * This class deals with typical operations over Nice_Testimonials_Post_Type instances.
 */
class Nice_Testimonials_Post_TypeService extends Nice_Testimonials_Service {
	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @since 1.1
	 *
	 * @uses  Nice_Testimonials_Post_TypeService::format_args()
	 * @uses  Nice_Testimonials_Post_TypeService::format_taxonomy()
	 *
	 * @param Nice_Testimonials_Post_Type $post_type
	 */
	public function register( Nice_Testimonials_Post_Type $post_type ) {
		$data = $post_type->get_info();

		/**
		 * Register taxonomies first to avoid possible rewrite conflicts.
		 */
		foreach ( $data->taxonomies as $taxonomy ) {
			self::register_taxonomy( self::format_taxonomy( $post_type, $taxonomy ) );
		}

		/**
		 * Register post types.
		 */
		self::register_post_type( self::format_args( $post_type ) );

		/**
		 * Flush rewrite rules if needed.
		 */
		self::flush_maybe( $post_type );
	}

	/**
	 * Create a custom taxonomy.
	 *
	 * @since  1.1
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/register_taxonomy
	 *
	 * @param  array $args
	 */
	protected static function register_taxonomy( array $args ) {
		call_user_func_array( 'register_taxonomy', $args );
	}

	/**
	 * Create a custom post type.
	 *
	 * @since  1.1
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/register_post_type
	 *
	 * @param  array $args
	 */
	protected static function register_post_type( array $args ) {
		call_user_func_array( 'register_post_type', $args );
	}

	/**
	 * Correctly format given arguments to create a custom post type.
	 *
	 * @since  1.1
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/register_post_type
	 *
	 * @param  Nice_Testimonials_Post_Type $post_type
	 *
	 * @return array
	 */
	public static function format_args( Nice_Testimonials_Post_Type $post_type ) {
		$data           = $post_type->get_info();
		$post_type_args = $data->args;

		// Normalize $post_type data.
		$post_type_defaults = array(
			'name'    => empty( $post_type_args['name'] )    ? array() : $post_type_args['name'],
			'labels'  => empty( $post_type_args['labels'] )  ? array() : $post_type_args['labels'],
			'support' => empty( $post_type_args['support'] ) ? array() : $post_type_args['support'],
			'args'    => empty( $post_type_args['args'] )    ? array() : $post_type_args['args'],
		);
		$post_type_args = wp_parse_args( $post_type_args, $post_type_defaults );

		// Define names.
		$public_name    = ! empty( $labels['name'] ) ? $labels['name'] : $post_type_args['name'];
		$singular_name  = ! empty( $labels['singular_name'] ) ? $labels['singular_name'] : $public_name;
		$lowercase_name = strtolower( $public_name );

		// Normalize labels.
		$default_labels = array(
			'name'               => $public_name,
			'singular_name'      => $singular_name,
			'add_new'            => sprintf( esc_html__( 'Add %s',             'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'add_new_item'       => sprintf( esc_html__( 'Add %s',             'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'edit_item'          => sprintf( esc_html__( 'Edit %s',            'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'new_item'           => sprintf( esc_html__( 'New %s',             'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'view_item'          => sprintf( esc_html__( 'View %s',            'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'search_items'       => sprintf( esc_html__( 'Search %s',          'nice-testimonials-plugin-textdomain' ), $public_name ),
			'not_found'          => sprintf( esc_html__( 'No %s found',        'nice-testimonials-plugin-textdomain' ), $lowercase_name ),
			'not_found_in_trash' => sprintf( esc_html__( 'No %s in the trash', 'nice-testimonials-plugin-textdomain' ), $lowercase_name ),
		);
		$labels = wp_parse_args( $post_type_args['labels'], $default_labels );

		// Normalize support.
		$supports_default = array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'revisions',
		);
		$supports = ! empty( $supports ) ? $supports : $supports_default;

		// Normalize arguments.
		$default_args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => $post_type_args['name'] ), // Permalinks format
			'menu_position'   => 25,
			'menu_icon'       => '',
		);

		$args = wp_parse_args( $post_type_args['args'], $default_args );
		$args = apply_filters( 'nice_testimonials_post_type_default_args', $args, $data, $post_type_args );

		return array(
			'name' => $post_type_args['name'],
			'args' => $args,
		);
	}

	/**
	 * Correctly format given arguments to create a custom taxonomy.
	 *
	 * @since  1.1
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/register_taxonomy
	 *
	 * @param  Nice_Testimonials_Post_Type $post_type
	 * @param  array $taxonomy
	 *
	 * @return array
	 */
	public static function format_taxonomy( Nice_Testimonials_Post_Type $post_type, array $taxonomy = array() ) {
		$data = $post_type->get_info();

		// Normalize $taxonomy data.
		$taxonomy_defaults = array(
			'name'    => $data->taxonomies[0],
			'labels'  => array(),
			'args'    => array(),
		);
		$taxonomy = wp_parse_args( $taxonomy, $taxonomy_defaults );

		// Define names.
		$public_name    = empty( $labels['name'] ) ? ucfirst( $taxonomy['name'] ) : $labels['name'];
		$singular_name  = empty( $labels['singular_name'] ) ? $public_name     : $labels['singular_name'];
		$lowercase_name = strtolower( $public_name );

		// Normalize labels.
		$default_labels = array(
			'name'                       => $public_name,
			'singular_name'              => $singular_name,
			'menu_name'                  => $public_name,
			'edit_item'                  => sprintf( esc_html__( 'Edit %s',                      'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'update_item'                => sprintf( esc_html__( 'Update %s',                    'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'add_new_item'               => sprintf( esc_html__( 'Add New %s',                   'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'new_item_name'              => sprintf( esc_html__( 'New %s Name',                  'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'parent_item'                => sprintf( esc_html__( 'Parent %s',                    'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'parent_item_colon'          => sprintf( esc_html__( 'Parent %s:',                   'nice-testimonials-plugin-textdomain' ), $singular_name ),
			'all_items'                  => sprintf( esc_html__( 'All %s',                       'nice-testimonials-plugin-textdomain' ), $public_name ),
			'search_items'               => sprintf( esc_html__( 'Search %s',                    'nice-testimonials-plugin-textdomain' ), $public_name ),
			'popular_items'              => sprintf( esc_html__( 'Popular %s',                   'nice-testimonials-plugin-textdomain' ), $public_name ),
			'separate_items_with_commas' => sprintf( esc_html__( 'Separate %s with commas',      'nice-testimonials-plugin-textdomain' ), $lowercase_name ),
			'add_or_remove_items'        => sprintf( esc_html__( 'Add or remove %s',             'nice-testimonials-plugin-textdomain' ), $lowercase_name ),
			'choose_from_most_used'      => sprintf( esc_html__( 'Choose from the most used %s', 'nice-testimonials-plugin-textdomain' ), $lowercase_name ),
			'not_found'                  => sprintf( esc_html__( 'No %s found.',                 'nice-testimonials-plugin-textdomain' ), $lowercase_name ),
		);
		$labels = wp_parse_args( $taxonomy['labels'], $default_labels );

		// Normalize arguments.
		$default_args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => $taxonomy['name'] ),
			'show_admin_column' => true,
			'query_var'         => true,
		);
		$args = wp_parse_args( $taxonomy['args'], $default_args );
		$args = apply_filters( 'nice_testimonials_post_type_category_default_args', $args, $post_type, $taxonomy );

		return array(
			'taxonomy'    => $taxonomy['name'],
			'object_type' => $data->args['name'],
			'args'        => $args,
		);
	}

	/**
	 * Create an option to flush rewrite rules when needed.
	 *
	 * @since 1.1
	 */
	public static function create_rewrite_rules_option() {
		static $done = null;

		if ( $done ) {
			return;
		}

		add_option( '_nice_testimonials_post_type_flushed', array() );

		$done = true;
	}

	/**
	 * Remove flushing option.
	 *
	 * @since 1.1
	 */
	public static function delete_rewrite_rules_option() {
		delete_option( '_nice_testimonials_post_type_flushed' );
	}

	/**
	 * Flush rewrite rules only once for every registered post type.
	 *
	 * @since 1.1
	 *
	 * @param Nice_Testimonials_Post_Type $post_type
	 */
	public static function flush_maybe( Nice_Testimonials_Post_Type $post_type ) {
		$data    = $post_type->get_info();
		$flushed = get_option( '_nice_testimonials_post_type_flushed' );

		if ( empty( $flushed[ $data->args['name'] ] ) ) {
			$flushed[ $data->args['name'] ] = true;
			flush_rewrite_rules();
			update_option( '_nice_testimonials_post_type_flushed', $flushed );
		}
	}
}
