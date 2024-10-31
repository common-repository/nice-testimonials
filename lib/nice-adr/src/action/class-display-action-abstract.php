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
 * Class Nice_Testimonials_DisplayActionAbstract
 *
 * This class takes charge of the plugin activation process and the preparation
 * of the related responder.
 *
 * @package Nice_Testimonials_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
abstract class Nice_Testimonials_DisplayActionAbstract extends Nice_Testimonials_ActionAbstract {
	/**
	 * Create new Nice_Testimonials_EntityInterface instance and fire responder.
	 *
	 * @since  1.0
	 *
	 * @param  array                          $data Data to create the new instance.
	 *
	 * @return Nice_Testimonials_EntityInterface
	 */
	public function __invoke( array $data ) {
		$instance = $this->domain->prepare( $data );
		$this->responder->__invoke( $instance );
	}
}
