<?php
/**
 * NiceThemes ADR
 *
 * @package Nice_Testimonials_ADR
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Testimonials_Factory
 *
 * This class applies a typical factory method pattern to the creation of
 * Nice_Testimonials_EntityInterface instances. It's meant to be used as a default
 * class for domains that, while needing to implement a factory, don't need any
 * specific functionality for it.
 *
 * @since 1.0
 */
class Nice_Testimonials_Factory implements Nice_Testimonials_FactoryInterface {
	/**
	 * Create a new instance of a given class.
	 *
	 * @since  1.0
	 *
	 * @param  array                $data Information for the new instance.
	 *
	 * @return Nice_Testimonials_EntityInterface
	 *
	 * @throws Exception
	 */
	public static function create( array $data ) {
		try {
			$classname = isset( $data['classname'] ) ? $data['classname'] : null;

			if ( ! $classname ) {
				return null;
			}

			unset( $data['classname'] );

			return new $classname( $data );
		} catch ( Exception $e ) {
			throw $e;
		}
	}
}
