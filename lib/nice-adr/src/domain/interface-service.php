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
 * Interface Nice_Testimonials_ServiceInterface
 *
 * @package Nice_Testimonials_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
interface Nice_Testimonials_ServiceInterface {
	/**
	 * Create a new Nice_Testimonials_EntityInterface instance.
	 *
	 * @since  1.0
	 *
	 * @param  array                          $data Information to create a new instance.
	 *
	 * @return Nice_Testimonials_EntityInterface
	 */
	public function create( array $data );

	/**
	 * Update a Nice_Testimonials_EntityInterface instance.
	 *
	 * @since  1.0
	 *
	 * @param  Nice_Testimonials_EntityInterface $instance Instance to update.
	 * @param  array                          $data   New information for instance.
	 */
	public function update( Nice_Testimonials_EntityInterface $instance, array $data );

	/**
	 * Update and return an instance.
	 *
	 * @since 1.0
	 *
	 * @param array $data
	 *
	 * @return Nice_Testimonials_EntityInterface
	 */
	public function get_updated( array $data );

	/**
	 * Prepare a Nice_Testimonials_EntityInterface instance to be displayed.
	 *
	 * @since  1.0
	 *
	 * @param  array $data Information to prepare the instance.
	 *
	 * @return Nice_Testimonials_EntityInterface
	 */
	public function prepare( array $data );
}
