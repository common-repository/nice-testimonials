<?php
/**
 * NiceThemes Plugin API
 *
 * @package Nice_Testimonials_Plugin_API
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Testimonials_MetaboxCreateResponder
 *
 * This class takes charge of the interaction of created Nice_Testimonials_Metabox
 * instances with WordPress APIs.
 *
 * @since 1.1
 */
class Nice_Testimonials_MetaboxCreateResponder extends Nice_Testimonials_CreateResponder {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.1
	 */
	protected function set_interactions() {
		/**
		 * Register meta data.
		 */
		add_action( 'add_meta_boxes', array( $this, 'register_metadata' ) );

		/**
		 * Initialize meta boxes.
		 */
		add_action( 'add_meta_boxes', array( $this, 'register_metabox' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Register meta data.
	 *
	 * @since 1.0
	 */
	public function register_metadata() {
		$fields = $this->data->fields;

		foreach ( $fields as $field ) {
			$meta_type    = empty( $field['meta_type'] ) ? 'post' : $field['meta_type'];
			$sanitization = empty( $field['sanitization_callback'] ) ? 'sanitize_text_field' : $field['sanitization_callback'];
			$auth         = empty( $field['auth_callback'] ) ? '__return_true' : $field['auth_callback'];

			register_meta( $meta_type, $field['name'], $sanitization, $auth );
		}
	}

	/**
	 * Init metaboxes action.
	 *
	 * @since 1.1
	 */
	public function register_metabox() {
		$fields = $this->data->fields;

		if ( ! empty( $fields ) ) {
			$this->add_metabox();
		}
	}

	/**
	 * Add meta boxes for each post type.
	 *
	 * @since 1.1
	 */
	public function add_metabox() {
		$data = $this->data->get_info();

		foreach ( $data->post_types as $post_type ) {
			call_user_func_array( 'add_meta_box', $this->get_metabox_settings( $post_type ) );
		}
	}

	/**
	 * Obtain settings to add a meta box.
	 *
	 * @since  1.1
	 *
	 * @param  string $post_type Name of the post type.
	 *
	 * @return array
	 */
	protected function get_metabox_settings( $post_type ) {
		$data = $this->data->get_info();

		$defaults = array(
			'id' 			=> $data->id ? : 'nice-testimonials-' . $post_type . '-settings',
			'title' 		=> sprintf( esc_html__( '%s Settings', 'nice-testimonials-plugin-textdomain' ), ucfirst( $post_type ) ),
			'callback' 		=> 'nice_testimonials_metabox_print',
			'post_type'     => $post_type,
			'context'       => $data->context ? : 'advanced',
			'priority' 		=> 'default',
			'callback_args' => array( 'instance' => $this->data ),
		);

		$settings = wp_parse_args( $data->settings, $defaults );
		$settings = apply_filters( 'nice_testimonials_metabox_' . $post_type . '_settings', $settings );

		return $settings;
	}
}
