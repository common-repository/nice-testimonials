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
 * Class Nice_Testimonials_GlancerService
 *
 * This class deals with typical operations over Nice_Testimonials_Glancer instances.
 *
 * @since 1.1
 */
class Nice_Testimonials_GlancerService extends Nice_Testimonials_Service {
	/**
	 * Create and return a new Nice_Testimonials_Glancer instance.
	 *
	 * @since  1.1
	 *
	 * @param  array $data Information to create the new instance.
	 *
	 * @return Nice_Testimonials_Glancer
	 */
	public function create( array $data ) {
		return $this->setup( $data );
	}

	/**
	 * Fire all necessary internal processes before returning the new instance.
	 *
	 * @param  array $data Information to create the new instance.
	 *
	 * @return Nice_Testimonials_Glancer
	 */
	protected function setup( array $data ) {
		/**
		 * Obtain an instance of Nice_Testimonials_Pointer_Collection.
		 */
		$glancer = parent::create( $data );

		/**
		 * Return instance.
		 */
		return $glancer;
	}

	/**
	 * Register one or more post type items to be shown on the dashboard widget.
	 *
	 * @uses  Nice_Testimonials_Glancer::update()
	 *
	 * @since 1.1
	 *
	 * @param Nice_Testimonials_Glancer $glancer Instance to be updated.
	 * @param array|string  $post_types Post type name, or array of post type names.
	 * @param array|string  $statuses Post status or array of different post type statuses
	 * @param string $glyph Dashicons glyph for current post type.
	 */
	public function add_item( Nice_Testimonials_Glancer $glancer, $post_types, $statuses = 'publish', $glyph = '' ) {
		/**
		 * If relevant output action hook has already passed, then there's no
		 * point in proceeding.
		 */
		if ( did_action( 'dashboard_glance_items' ) ) {
			_doing_it_wrong( __CLASS__, esc_html__( 'Trying to add At a Glance items to dashboard widget after hook already fired', 'nice-testimonials-plugin-textdomain' ), '1.1' );
			return;
		}

		/**
		 * Obtain clean list of post types.
		 */
		$post_types = (array) $post_types;

		// Return if we don't have any post type.
		if ( empty( $post_types ) ) {
			return;
		}

		/**
		 * Get instance data.
		 */
		$data = $glancer->get_info( true );

		/**
		 * Register each combination of given post type and status.
		 */
		foreach ( $post_types as $post_type ) {
			foreach ( (array) $statuses as $status ) {
				$data['items'][] = array(
					'type'   => $post_type,
					'status' => $status, // No checks yet to see if status is valid
					'glyph'  => $glyph,
				);
			}
		}

		$this->update( $glancer, $data );
	}

	/**
	 * Check one or more post types to see if they are valid.
	 *
	 * @since 1.1
	 *
	 * @param array $post_types Each of the post types to check.
	 *
	 * @return array List of the given post types that are valid.
	 */
	protected static function process_post_types( array $post_types ) {
		foreach ( $post_types as $index => $post_type ) {
			$post_type_object = get_post_type_object( $post_type );

			if ( is_null( $post_type_object ) ) {
				unset( $post_types[ $index ] );
			}
		}

		return $post_types;
	}
}
