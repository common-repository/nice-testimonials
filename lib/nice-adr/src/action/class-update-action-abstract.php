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
 * Class Nice_Testimonials_UpdateActionAbstract
 *
 * This class takes charge of the update processes fired against the WordPress API.
 *
 * @package Nice_Testimonials_ADR
 * @since   1.0
 */
abstract class Nice_Testimonials_UpdateActionAbstract extends Nice_Testimonials_ActionAbstract {
	/**
	 * Prepare a Nice_Testimonials_EntityInterface instance to be updated.
	 *
	 * @since  1.0
	 *
	 * @param  array                          $data Data to create the new instance.
	 *
	 * @return Nice_Testimonials_EntityInterface
	 */
	public function __invoke( array $data ) {
		$instance = $this->domain->get_updated( $data );
		$this->responder->__invoke( $instance );
	}
}
