<?php
/**
 * NiceThemes ADR
 *
 * @package Nice_Testimonials_ADR
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Testimonials_Entity
 *
 * @package Nice_Testimonials_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
abstract class Nice_Testimonials_Entity implements Nice_Testimonials_EntityInterface {
	/**
	 * Set instance values.
	 *
	 * @since 1.0
	 *
	 * @param array $data Information for instance properties.
	 */
	public function __construct( array $data ) {
		$this->set_data( $data );
	}

	/**
	 * Assign values to instance properties.
	 *
	 * @since 1.0
	 *
	 * @param array $data Information for current instance.
	 */
	public function set_data( array $data ) {
		foreach ( $data as $key => $value ) {
			if ( property_exists( $this, $key ) ) {
				$this->{$key} = $value;
			}
		}
	}

	/**
	 * Obtain the current value of a property.
	 *
	 * @since  1.0
	 *
	 * @param  string     $property Name of a property of this class.
	 *
	 * @return mixed|void           Current value for the requested property.
	 */
	public function __get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->{$property};
		}

		return null;
	}

	/**
	 * Obtain current state of this instance.
	 *
	 * @since  1.0
	 *
	 * @param  bool           $array Set to true if the information should be returned as an array.
	 *
	 * @return stdClass|array
	 */
	public function get_info( $array = false ) {
		if ( $array ) {
			return get_object_vars( $this );
		}

		return (object) get_object_vars( $this );
	}
}
