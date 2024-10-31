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
 * Interface Nice_Testimonials_ActionInterface
 *
 * @package Nice_Testimonials_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
interface Nice_Testimonials_ActionInterface {
	/**
	 * Create new Nice_Testimonials_Plugin instance and fire responder.
	 *
	 * @since 1.0
	 *
	 * @param array $data Data to create a new instance.
	 */
	public function __invoke( array $data );
}
