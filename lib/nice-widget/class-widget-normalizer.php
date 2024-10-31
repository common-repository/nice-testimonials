<?php
/**
 * NiceThemes Widget API
 *
 * @package Nice_Testimonials_Widget_API
 * @license GPL-2.0+
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Nice_Testimonials_Widget_Normalizer
 *
 * Manage common operations for widgets.
 *
 * @since 1.0
 */
class Nice_Testimonials_Widget_Normalizer {
	/**
	 * Default values and sanitization functions.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $instance_defaults = array();

	/**
	 * Values that should be used for properties when none is sent via request.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $fallback_instance = array();

	/**
	 * Default values for widget instance.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $default_instance = array();

	/**
	 * Sanitization functions for instance settings.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $instance_sanitizers = array();

	/**
	 * Initialize object.
	 *
	 * @since 1.0
	 *
	 * @param array $instance_defaults
	 */
	public function __construct( $instance_defaults = array() ) {
		$this->instance_defaults = $instance_defaults;
		$this->set_fallback_instance();
		$this->set_default_instance();
		$this->set_instance_sanitizers();
	}

	/**
	 * Initialize default widget instance.
	 *
	 * @since 1.0
	 */
	private function set_default_instance() {
		$default_instance = array();

		if ( ! empty( $this->instance_defaults ) ) {
			foreach ( $this->instance_defaults as $key => $value ) {
				if ( ! isset( $value[0] ) ) {
					continue;
				}

				$default_instance[ $key ] = $value[0];
			}
		}

		$this->default_instance = $default_instance;
	}

	/**
	 * Initialize fallback values for widget instance.
	 *
	 * @since 1.0
	 */
	private function set_fallback_instance() {
		$fallback_instance = array();

		if ( ! empty( $this->instance_defaults ) ) {
			foreach ( $this->instance_defaults as $key => $value ) {
				if ( ! isset( $value[2] ) ) {
					continue;
				}

				$fallback_instance[ $key ] = $value[2];
			}
		}

		$this->fallback_instance = $fallback_instance;
	}

	/**
	 * Initialize settings sanitizers.
	 *
	 * @since 1.0
	 */
	private function set_instance_sanitizers() {
		$instance_sanitizers = array();

		if ( ! empty( $this->instance_defaults ) ) {
			foreach ( $this->instance_defaults as $key => $value ) {
				if ( ! isset( $value[1] ) ) {
					continue;
				}

				$instance_sanitizers[ $key ] = $value[1];
			}
		}

		$this->instance_sanitizers = $instance_sanitizers;
	}

	/**
	 * Normalize a given widget instance using the default one.
	 *
	 * @since  1.0
	 *
	 * @param  array $instance
	 * @return array
	 */
	function normalize_instance( $instance = array() ) {
		$defaults = $this->default_instance;
		$original_instance = $instance;
		$instance = wp_parse_args( $instance, $defaults );

		foreach ( $instance as $key => $value ) {
			if ( ! isset( $original_instance[ $key ] ) && isset( $this->fallback_instance[ $key ] ) ) {
				// Use fallback value if not sent via request.
				$value = $this->fallback_instance[ $key ];

			} elseif ( ! empty( $this->instance_sanitizers[ $key ] ) && function_exists( $this->instance_sanitizers[ $key ] ) ) {
				// Sanitize with specific function if provided.
				$value = call_user_func( $this->instance_sanitizers[ $key ], $value );

			} else {
				// Sanitize with fallback function.
				$value = esc_attr( $value );
			}

			$instance[ $key ] = $value;
		}

		return $instance;
	}
}
